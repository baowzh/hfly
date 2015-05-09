<?php


class phpzip
{

	var $version = "1.0";
	var $total_files = 0;
	var $total_folders = 0;
	var $file_count = 0;
	var $datastr_len = 0;
	var $dirstr_len = 0;
	var $filedata = "";
	var $gzfilename;
	var $fp;
	var $dirstr = "";
	var $srcDir = "";

	function phpzip( )
	{
	}

	function zip( $src, $dstFile )
	{
		if ( !$this->prepare( $dstFile ) )
		{
			exit( "Can not create ".$dstFile."." );
		}
		$arrSrc = is_array( $src ) ? $src : array(
			$src
		);
		$i = 0;
		for ( ;	$i < count( $arrSrc );	++$i	)
		{
			$src = $arrSrc[$i];
			$src = str_replace( "\\", "/", $src );
			if ( !file_exists( $src ) )
			{
				echo "Source ' ".$src." ' does not exist.<br>\n";
			}
			else if ( is_dir( $src ) )
			{
				$this->srcDir = $src;
				$this->adddir( $src );
			}
			else if ( is_file( $src ) )
			{
				$this->addfile( $src );
			}
		}
		$this->packup( );
		return TRUE;
	}

	function unzip( $srcFile, $dstDir )
	{
		if ( !file_exists( $srcFile ) )
		{
			exit( "' ".$srcFile." ' does not exist." );
		}
		$result = $this->extract( $srcFile, $dstDir );
		if ( -1 != $result )
		{
			return TRUE;
		}
		return FALSE;
	}

	function extract( $zn, $to, $index = array
	(
		0 => -1
	) )
	{
		$ok = 0;
		$zip = @fopen( $zn, "rb" );
		if ( !$zip )
		{
			return -1;
		}
		$cdir = $this->readcentraldir( $zip, $zn );
		$pos_entry = $cdir['offset'];
		if ( !is_array( $index ) )
		{
			$index = array(
				$index
			);
		}
		$i = 0;
		for ( ;	isset( $index[$i] );	++$i	)
		{
			if ( !( intval( $index[$i] ) != $index[$i] ) || !( $cdir['entries'] < $index[$i] ) )
			{
				continue;
			}
			return -1;
		}
		$i = 0;
		for ( ;	$i < $cdir['entries'];	++$i	)
		{
			@fseek( $zip, $pos_entry );
			$header = $this->readcentralfileheaders( $zip );
			$header['index'] = $i;
			$pos_entry = ftell( $zip );
			@rewind( $zip );
			fseek( $zip, $header['offset'] );
			if ( !in_array( "-1", $index ) || !in_array( $i, $index ) )
			{
				$stat[$header['filename']] = $this->extractfile( $header, $to, $zip );
			}
		}
		fclose( $zip );
		return $stat;
	}

	function readfileheader( $zip )
	{
		$binary_data = fread( $zip, 30 );
		$data = unpack( "vchk/vid/vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len", $binary_data );
		$header['filename'] = fread( $zip, $data['filename_len'] );
		if ( $data['extra_len'] != 0 )
		{
			$header['extra'] = fread( $zip, $data['extra_len'] );
		}
		else
		{
			$header['extra'] = "";
		}
		$header['compression'] = $data['compression'];
		$header['size'] = $data['size'];
		$header['compressed_size'] = $data['compressed_size'];
		$header['crc'] = $data['crc'];
		$header['flag'] = $data['flag'];
		$header['mdate'] = $data['mdate'];
		$header['mtime'] = $data['mtime'];
		if ( $header['mdate'] && $header['mtime'] )
		{
			$hour = ( $header['mtime'] & 63488 ) >> 11;
			$minute = ( $header['mtime'] & 2016 ) >> 5;
			$seconde = ( $header['mtime'] & 31 ) * 2;
			$year = ( ( $header['mdate'] & 65024 ) >> 9 ) + 1980;
			$month = ( $header['mdate'] & 480 ) >> 5;
			$day = $header['mdate'] & 31;
			$header['mtime'] = mktime( $hour, $minute, $seconde, $month, $day, $year );
		}
		else
		{
			$header['mtime'] = time( );
		}
		$header['stored_filename'] = $header['filename'];
		$header['status'] = "ok";
		return $header;
	}

	function readcentralfileheaders( $zip )
	{
		$binary_data = fread( $zip, 46 );
		$header = unpack( "vchkid/vid/vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset", $binary_data );
		if ( $header['filename_len'] != 0 )
		{
			$header['filename'] = fread( $zip, $header['filename_len'] );
		}
		else
		{
			$header['filename'] = "";
		}
		if ( $header['extra_len'] != 0 )
		{
			$header['extra'] = fread( $zip, $header['extra_len'] );
		}
		else
		{
			$header['extra'] = "";
		}
		if ( $header['comment_len'] != 0 )
		{
			$header['comment'] = fread( $zip, $header['comment_len'] );
		}
		else
		{
			$header['comment'] = "";
		}
		if ( $header['mdate'] && $header['mtime'] )
		{
			$hour = ( $header['mtime'] & 63488 ) >> 11;
			$minute = ( $header['mtime'] & 2016 ) >> 5;
			$seconde = ( $header['mtime'] & 31 ) * 2;
			$year = ( ( $header['mdate'] & 65024 ) >> 9 ) + 1980;
			$month = ( $header['mdate'] & 480 ) >> 5;
			$day = $header['mdate'] & 31;
			$header['mtime'] = mktime( $hour, $minute, $seconde, $month, $day, $year );
		}
		else
		{
			$header['mtime'] = time( );
		}
		$header['stored_filename'] = $header['filename'];
		$header['status'] = "ok";
		if ( substr( $header['filename'], -1 ) == "/" )
		{
			$header['external'] = 1107230736;
		}
		return $header;
	}

	function readcentraldir( $zip, $zip_name )
	{
		$size = filesize( $zip_name );
		if ( $size < 277 )
		{
			$maximum_size = $size;
		}
		else
		{
			$maximum_size = 277;
		}
		@fseek( $zip, $size - $maximum_size );
		$pos = ftell( $zip );
		$bytes = 0;
		while ( $pos < $size )
		{
			$byte = @fread( $zip, 1 );
			$bytes = $bytes << 8 | ord( $byte );
			if ( $bytes == 1347093766 || $bytes == 2147483647 )
			{
				++$pos;
			}
			else
			{
				++$pos;
			}
		}
		$fdata = fread( $zip, 18 );
		$data = @unpack( "vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size", $fdata );
		if ( $data['comment_size'] != 0 )
		{
			$centd['comment'] = fread( $zip, $data['comment_size'] );
		}
		else
		{
			$centd['comment'] = "";
		}
		$centd['entries'] = $data['entries'];
		$centd['disk_entries'] = $data['disk_entries'];
		$centd['offset'] = $data['offset'];
		$centd['disk_start'] = $data['disk_start'];
		$centd['size'] = $data['size'];
		$centd['disk'] = $data['disk'];
		return $centd;
	}

	function extractfile( $header, $to, $zip )
	{
		$header = $this->readfileheader( $zip );
		if ( substr( $to, -1 ) != "/" )
		{
			$to .= "/";
		}
		if ( $to == "./" )
		{
			$to = "";
		}
		$pth = explode( "/", $to.$header['filename'] );
		$mydir = "";
		$i = 0;
		for ( ;	$i < count( $pth ) - 1;	++$i	)
		{
			if ( $pth[$i] )
			{
				$mydir .= $pth[$i]."/";
				if ( !is_dir( $mydir ) || @!mkdir( $mydir, 511 ) || ( !( $mydir == $to.$header['filename'] ) || ( !( $mydir == $to ) && !( $this->total_folders == 0 ) ) && !is_dir( $mydir ) ) )
				{
					@chmod( $mydir, 511 );
					++$this->total_folders;
				}
			}
		}
		if ( strrchr( $header['filename'], "/" ) == "/" )
		{
			return;
		}
		$header['external'] = isset( $header['external'] ) ? $header['external'] : "";
		if ( !( $header['external'] == 1107230736 ) || !( $header['external'] == 16 ) )
		{
			if ( $header['compression'] == 0 )
			{
				$fp = @fopen( $to.$header['filename'], "wb" );
				if ( !$fp )
				{
					return -1;
				}
				$size = $header['compressed_size'];
				while ( $size != 0 )
				{
					$read_size = $size < 2048 ? $size : 2048;
					$buffer = fread( $zip, $read_size );
					$binary_data = pack( "a".$read_size, $buffer );
					@fwrite( $fp, $binary_data, $read_size );
					$size -= $read_size;
				}
				fclose( $fp );
				touch( $to.$header['filename'], $header['mtime'] );
			}
			else
			{
				$fp = @fopen( $to.$header['filename'].".gz", "wb" );
				if ( !$fp )
				{
					return -1;
				}
				$binary_data = pack( "va1a1Va1a1", 35615, chr( $header['compression'] ), chr( 0 ), time( ), chr( 0 ), chr( 3 ) );
				fwrite( $fp, $binary_data, 10 );
				$size = $header['compressed_size'];
				while ( $size != 0 )
				{
					$read_size = $size < 1024 ? $size : 1024;
					$buffer = fread( $zip, $read_size );
					$binary_data = pack( "a".$read_size, $buffer );
					@fwrite( $fp, $binary_data, $read_size );
					$size -= $read_size;
				}
				$binary_data = pack( "VV", $header['crc'], $header['size'] );
				fwrite( $fp, $binary_data, 8 );
				fclose( $fp );
				if ( !( $gzp = @gzopen( $to.$header['filename'].".gz", "rb" ) ) )
				{
					exit( "Cette archive est compress閑" );
				}
				if ( !$gzp )
				{
					return -2;
				}
				$fp = @fopen( $to.$header['filename'], "wb" );
				if ( !$fp )
				{
					return -1;
				}
				$size = $header['size'];
				while ( $size != 0 )
				{
					$read_size = $size < 2048 ? $size : 2048;
					$buffer = gzread( $gzp, $read_size );
					$binary_data = pack( "a".$read_size, $buffer );
					@fwrite( $fp, $binary_data, $read_size );
					$size -= $read_size;
				}
				fclose( $fp );
				gzclose( $gzp );
				touch( $to.$header['filename'], $header['mtime'] );
				@unlink( $to.$header['filename'].".gz" );
			}
		}
		++$this->total_files;
		return true;
	}

	function prepare( $path = "faisun.zip" )
	{
		$this->gzfilename = $path;
		$this->makedir( dirname( $path ) );
		if ( $this->fp = @fopen( $this->gzfilename, "w" ) )
		{
			return true;
		}
		return false;
	}

	function addfilecontent( $data, $name )
	{
		$name = str_replace( "\\", "", $name );
		$name = ereg_replace( "^".$this->srcDir, "", $name );
		$name = ereg_replace( "^/", "", $name );
		if ( strrchr( $name, "/" ) == "/" )
		{
			return $this->adddir( $name );
		}
		$dtime = dechex( $this->unix2dostime( ) );
		$hexdtime = "\\x".$dtime[6].$dtime[7]."\\x".$dtime[4].$dtime[5]."\\x".$dtime[2].$dtime[3]."\\x".$dtime[0].$dtime[1];
		eval( "\$hexdtime = \"".$hexdtime."\";" );
		$unc_len = strlen( $data );
		$crc = crc32( $data );
		$zdata = gzcompress( $data );
		$c_len = strlen( $zdata );
		$zdata = substr( substr( $zdata, 0, strlen( $zdata ) - 4 ), 2 );
		$datastr = "PK\x03\x04";
		$datastr .= "\x14\x00";
		$datastr .= "\x00\x00";
		$datastr .= "\x08\x00";
		$datastr .= $hexdtime;
		$datastr .= pack( "V", $crc );
		$datastr .= pack( "V", $c_len );
		$datastr .= pack( "V", $unc_len );
		$datastr .= pack( "v", strlen( $name ) );
		$datastr .= pack( "v", 0 );
		$datastr .= $name;
		$datastr .= $zdata;
		$datastr .= pack( "V", $crc );
		$datastr .= pack( "V", $c_len );
		$datastr .= pack( "V", $unc_len );
		fwrite( $this->fp, $datastr );
		$my_datastr_len = strlen( $datastr );
		unset( $datastr );
		$dirstr = "PK\x01\x02";
		$dirstr .= "\x00\x00";
		$dirstr .= "\x14\x00";
		$dirstr .= "\x00\x00";
		$dirstr .= "\x08\x00";
		$dirstr .= $hexdtime;
		$dirstr .= pack( "V", $crc );
		$dirstr .= pack( "V", $c_len );
		$dirstr .= pack( "V", $unc_len );
		$dirstr .= pack( "v", strlen( $name ) );
		$dirstr .= pack( "v", 0 );
		$dirstr .= pack( "v", 0 );
		$dirstr .= pack( "v", 0 );
		$dirstr .= pack( "v", 0 );
		$dirstr .= pack( "V", 32 );
		$dirstr .= pack( "V", $this->datastr_len );
		$dirstr .= $name;
		$this->dirstr .= $dirstr;
		++$this->file_count;
		$this->dirstr_len += strlen( $dirstr );
		$this->datastr_len += $my_datastr_len;
	}

	function adddir( $dir = "." )
	{
		$sub_file_num = 0;
		$handle = opendir( $dir );
		while ( $file = readdir( $handle ) )
		{
			if ( $file == "." || $file == ".." )
			{
				if ( is_dir( $dir."/{$file}" ) )
				{
					$sub_file_num += $this->adddir( $dir."/{$file}" );
				}
				else if ( realpath( $this->gzfilename ) != realpath( $dir."/{$file}" ) )
				{
					$this->addfilecontent( implode( "", file( $dir."/{$file}" ) ), $dir."/{$file}" );
					++$sub_file_num;
				}
			}
		}
		closedir( $handle );
		if ( !$sub_file_num )
		{
			$this->addfilecontent( "", $dir."/" );
		}
		return $sub_file_num;
	}

	function addfile( $filename )
	{
		$fp = fopen( $filename, "r" );
		$content = fread( $fp, filesize( $filename ) );
		fclose( $fp );
		$filename = basename( $filename );
		$this->addfilecontent( $content, $filename );
	}

	function packup( )
	{
		$endstr = "PK\x05\x06\x00\x00\x00\x00".pack( "v", $this->file_count ).pack( "v", $this->file_count ).pack( "V", $this->dirstr_len ).pack( "V", $this->datastr_len )."\x00\x00";
		fwrite( $this->fp, $this->dirstr.$endstr );
		fclose( $this->fp );
	}

	function makedir( $path )
	{
		if ( file_exists( $path ) )
		{
			return true;
		}
		$dirs = explode( "/", $path );
		$dir_tmp = "";
		$i = 0;
		for ( ;	$i < count( $dirs );	++$i	)
		{
			$dir_tmp .= $dirs[$i]."/";
			if ( !file_exists( $dir_tmp ) )
			{
				if ( !@mkdir( $dir_tmp ) )
				{
					exit( "Error: Can not create ".$dir_tmp."." );
				}
			}
		}
		return true;
	}

	function unix2dostime( $unixtime = 0 )
	{
		$timearray = $unixtime == 0 ? getdate( ) : getdate( $unixtime );
		if ( $timearray['year'] < 1980 )
		{
			$timearray['year'] = 1980;
			$timearray['mon'] = 1;
			$timearray['mday'] = 1;
			$timearray['hours'] = 0;
			$timearray['minutes'] = 0;
			$timearray['seconds'] = 0;
		}
		return $timearray['year'] - 1980 << 25 | $timearray['mon'] << 21 | $timearray['mday'] << 16 | $timearray['hours'] << 11 | $timearray['minutes'] << 5 | $timearray['seconds'] >> 1;
	}

}

?>
