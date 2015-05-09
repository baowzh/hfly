/*--------------------------------------------------|

| TableTree4j 1.2Release                           |

| IE Mozilla  Opera  FireFox  Netscape  Safari      |

| www.xcode-studio.cn                               |

|---------------------------------------------------|

| authod : Lanner.K       YuBiao Ke                 |

| QQ:214392346  E-Mail:lannerk@qq.com               |

| http://www.xcode-studio.cn                        |

|---------------------------------------------------|

| Copyright (c) 2007-2008 xcode-studio              |

| This script can be used freely as long as all     |

| copyright messages are intact.                    |

| Create Date: 2008.5.7                             |

| Updated: 2008.1.20                                |

|--------------------------------------------------*/




//TableTree4J Object
function TableTree4J(objectName,tableTree4JDir){
	//vars-------------------------------------------------------------------	
    this.tableTree4JDir=tableTree4JDir;	
	this.obj=objectName;
	this.treeNodes=[];
	this.htmlCode="";
	this.rootNode;
	this.headerWidthList;
	this.gridHeaderColStyleArray=[];
	this.gridDataCloStyleArray=[];
	this.tableDesc;
	this.selectMenuNodeHrefId;
	this.map=new HashMap();
	
	this.icon ={
		root:this.tableTree4JDir+'img/base.gif',
		folder:this.tableTree4JDir+'img/folder.gif',
		folderOpen:this.tableTree4JDir+'img/folderopen.gif',
		node:this.tableTree4JDir+'img/page.gif',
		empty:this.tableTree4JDir+'img/empty.gif',
		line:this.tableTree4JDir+'img/line.gif',
		join:this.tableTree4JDir+'img/join.gif',
		joinBottom:this.tableTree4JDir+'img/joinbottom.gif',
		plus:this.tableTree4JDir+'img/plus.gif',
		plusBottom:this.tableTree4JDir+'img/plusbottom.gif',
		minus:this.tableTree4JDir+'img/minus.gif',
		minusBottom:this.tableTree4JDir+'img/minusbottom.gif',
		nlPlus:this.tableTree4JDir+'img/nolines_plus.gif',
		nlMinus:this.tableTree4JDir+'img/nolines_minus.gif'
	};	
	this.config={
		treeMode:"GRID",//"MENU"
		treeStyle:"GRIDTREESTYLE",//"MENUTREESTYLE"
		dafultTarget:null,
		rootNodeBtn:true,
		folderAutoUrl:false,
		nodeHrefSelectBg:false,
		hrefOnfouceLine:false,
		hrefIconOnfouceLine:false,
		showTipTitle:true,
		showStatusText:true,
		inOrder:true,
		useCookies:false,
		cookieTime:30*24*60*60*1000,
		useIcon:false,
		useLine:true,
		booleanInitOpenAll:false,
		booleanHighLightRow:true,
		highLightRowClassName:"GridHighLightRow"
	}
	
	//set img root path
	TableTree4J.prototype.setImgRootPath=function(path){
		this.icon.root=path+'base.gif';
		this.icon.folder=path+'folder.gif';
		this.icon.folderOpen=path+'folderopen.gif';
		this.icon.node=path+'page.gif';
		this.icon.empty=path+'empty.gif';
		this.icon.line=path+'line.gif';
		this.icon.join=path+'join.gif';
		this.icon.joinBottom=path+'joinbottom.gif';
		this.icon.plus=path+'plus.gif';
		this.icon.plusBottom=path+'plusbottom.gif';
		this.icon.minus=path+'minus.gif';
		this.icon.minusBottom=path+'minusbottom.gif';
		this.icon.nlPlus=path+'nolines_plus.gif';
		this.icon.nlMinus=path+'nolines_minus.gif';		
	}	
	
	//when a GIRD mode ,init the table	
	TableTree4J.prototype.descTable=function(desc){
		this.tableDesc=desc;
	}	
	
	//change tree to menu mode
	TableTree4J.prototype.toMenuMode=function(){
		this.config.treeMode="MENU";
		this.config.treeStyle="MENUTREESTYLE";
		this.config.rootNodeBtn=false;
		this.config.folderAutoUrl=true;
		this.config.nodeHrefSelectBg=true;
		this.config.useIcon=true;
		this.config.booleanHighLightRow=false;
		this.descTable("<table border=\"0\" id=\""+this.obj+"Table\" width=\"100%\" cellpadding=\"0\" style=\"border-collapse: collapse\" >");
	}
		
	//set menu tree root
	TableTree4J.prototype.setMenuRoot=function(rootName,id,booleanOpen,classStyle,hrefTip,hrefStatusText,icon,iconOpen){
		var menuRootStyle=classStyle;//||"MenuRoot";
		var menuRootIcon=icon||this.icon.root;
		var menuRootOpenIcon=iconOpen||this.icon.root;
		var menuRootbooleanOpen=booleanOpen;
		if(menuRootbooleanOpen==null||menuRootbooleanOpen==""){
			menuRootbooleanOpen=true;
		}

		//cookie
		if(this.config.useCookies==true){
			if(booleanNodeInOpenCookie(id,this)==1){
					menuRootbooleanOpen=true;
			}
			if(booleanNodeInOpenCookie(id,this)==2){
					menuRootbooleanOpen=false;
			}			
		}			
		
		//dataList,id,pid,booleanOpen,order,url,target,classStyle,icon,iconOpen
		var nod=new Node(new Array(rootName),id,"",menuRootbooleanOpen,"",null,null,menuRootStyle,menuRootIcon,menuRootOpenIcon,hrefTip,hrefStatusText);		
		if(menuRootIcon==null||menuRootIcon==""){
			nod.icon=this.icon.root;
		}
		if(menuRootOpenIcon==null||menuRootOpenIcon==""){
			nod.iconOpen=this.icon.root;
		}

						
		//nod.tableOrder=0;
		nod.level=0;
		nod.booleanRoot=true;
		nod.booleanLastNode=true;
		nod.visible="";
		this.rootNode=nod;
		this.map.put("treNod"+nod.id,nod);	
	}
	
	//click a menuNode url
	TableTree4J.prototype.menuNodeHrefClick=function(hrefid){
		var hrefClickNode=document.getElementById(hrefid);
		if(hrefClickNode!=null){
			if(this.selectMenuNodeHrefId!=null&&this.selectMenuNodeHrefId!=hrefid){
				var oldClickNode=document.getElementById(this.selectMenuNodeHrefId);
				oldClickNode.className="";									
			}	
			this.selectMenuNodeHrefId=hrefid;
			hrefClickNode.className="nodeSel";
			}
		}
			
	
	//add menu node
	TableTree4J.prototype.addMenuNode=function(menuName,id,pid,booleanOpen,order,url,target,hrefTip,hrefStatusText,classStyle,icon,iconOpen){
		var nod=new Node(new Array(menuName),id,pid,booleanOpen,order,url,target,classStyle,icon,iconOpen,hrefTip,hrefStatusText);
		this.addNode(nod);
	}		
	
	//add grid node
	TableTree4J.prototype.addGirdNode=function(dataList,id,pid,booleanOpen,order,url,target,hrefTip,hrefStatusText,classStyle,icon,iconOpen){
		var nod=new Node(dataList,id,pid,booleanOpen,order,url,target,classStyle,icon,iconOpen,hrefTip,hrefStatusText);
		this.addNode(nod);
	}
	
	//set the tabletree list header
	TableTree4J.prototype.setHeader=function(arrayHeader,id,headerWidthList,booleanOpen,classStyle,hrefTip,hrefStatusText,icon,iconOpen){
		
		var headerStyle=classStyle;//||"GridHead";
		var headerIcon=icon||this.icon.root;
		var headerOpenIcon=iconOpen||this.icon.root;
		var headerbooleanOpen=booleanOpen;
		if(headerbooleanOpen==null||headerbooleanOpen==""){
			headerbooleanOpen=true;
		}
		
		//cookie
		if(this.config.useCookies==true){
			if(booleanNodeInOpenCookie(id,this)==1){
					headerbooleanOpen=true;
			}
			if(booleanNodeInOpenCookie(id,this)==2){
					headerbooleanOpen=false;
			}			
		}		
		
		//dataList,id,pid,booleanOpen,order,url,target,classStyle,icon,iconOpen
		var nod=new Node(arrayHeader,id,"",headerbooleanOpen,"",null,null,headerStyle,headerIcon,headerOpenIcon,hrefTip,hrefStatusText);
		if(headerIcon==null||headerIcon==""){
			nod.icon=this.icon.root;
		}
		if(headerOpenIcon==null||headerOpenIcon==""){
			nod.iconOpen=this.icon.root;
		}
						
		this.headerWidthList=headerWidthList;
		//nod.tableOrder=0;
		nod.level=0;
		nod.booleanRoot=true;
		nod.booleanLastNode=true;
		nod.visible="";
		this.rootNode=nod;
		this.map.put("treNod"+nod.id,nod);
	}			
	
	//add a tree node
	TableTree4J.prototype.addNode=function(node){
		this.treeNodes[this.treeNodes.length]=node;
		this.map.put("treNod"+node.id,node);
		if(node.booleanOpen==null||node.booleanOpen==""){
			node.booleanOpen=this.config.booleanInitOpenAll;
		}
		
		//cookie
		if(this.config.useCookies==true){
			if(booleanNodeInOpenCookie(node.id,this)==1){
					node.booleanOpen=true;
			}
			if(booleanNodeInOpenCookie(node.id,this)==2){
					node.booleanOpen=false;
			}			
		}
		
		
		if(node.target==null||node.target==""){
			node.target=this.config.dafultTarget;
		}
		
	}
		
	//show the tabletree to an html element
	TableTree4J.prototype.printTableTreeToElement=function(elementId){
		this.initNodes();
		var container=document.getElementById(elementId);
		//alert(this.htmlCode);
		container.innerHTML=this.tableDesc+this.htmlCode+"</table>";
	}
	
	//show tree when the html init
	TableTree4J.prototype.printTableTree=function(){
		this.initNodes();
		//alert(this.htmlCode);
		document.write(this.tableDesc+this.htmlCode+"</table>");
		document.close();

	}	
	
	//init node img html code
	TableTree4J.prototype.codeNodeImgByPath=function(imgpath,nodeId){
		return "<img border=\"0\" id=\""+this.obj+"ImgNod"+nodeId+"\" align=\"absmiddle\" src=\""+imgpath+"\"/>";
	}
	
		
	
	//init a static img html code by img path
	TableTree4J.prototype.codeStaticImgByPath=function(imgpath){
		return "<img border=\"0\" align=\"absmiddle\" src=\""+imgpath+"\"/>";
	}

	//init a Dony img html code by img path
	TableTree4J.prototype.codeDonyImgByPath=function(imgpath,nodeId){
		if(this.config.hrefIconOnfouceLine==false){
			return "<a style=\"border:none\" onfocus=\"this.blur()\" href=\"javascript:clickNode('"+nodeId+"',"+this.obj+")\"><img id=\""+this.obj+"Nodimg"+nodeId+"\" border=\"0\" align=\"absmiddle\" src=\""+imgpath+"\"/></a>";
		}else{
			return "<a style=\"border:none\" href=\"javascript:clickNode('"+nodeId+"',"+this.obj+")\"><img id=\""+this.obj+"Nodimg"+nodeId+"\" border=\"0\" align=\"absmiddle\" src=\""+imgpath+"\"/></a>";
		}
	}
	
	//init node img
	TableTree4J.prototype.codeNodeIcon=function(node){
		var imgstr="";
		var imgpath="";

		if(node.booleanLeaf==true){
			if(node.icon==null||node.icon==""){
				node.icon=this.icon.node;
			}
			if(node.iconOpen==null||node.iconOpen==""){
				node.iconOpen=this.icon.node;
			}	
			imgpath=node.icon;	
		}else{
			if(node.icon==null||node.icon==""){
				node.icon=this.icon.folder;
			}
			if(node.iconOpen==null||node.iconOpen==""){
				node.iconOpen=this.icon.folderOpen;
			}
			
			if(node.booleanOpen==true){
				imgpath=node.iconOpen;	
			}else{
				imgpath=node.icon;	
			}
						
		}
		
		if(this.config.useIcon==true){
			imgstr=this.codeNodeImgByPath(imgpath,node.id);
		}
		return imgstr;
	}	
	
	//init node imgBtn 
	TableTree4J.prototype.codeNodeImg=function(node){
		var imgstr="";
		
		if(this.config.rootNodeBtn==false&&node.booleanRoot==true){
			return imgstr;
		}
		
		if(this.config.useLine==true){
			if(node.booleanLastNode==true){
				if(node.booleanLeaf==true){
					imgstr=this.codeStaticImgByPath(this.icon.joinBottom);
				}else{
					 node.cloBtnImg=this.icon.plusBottom;
					 node.opnBtnImg=this.icon.minusBottom;
					if(node.booleanOpen==true){
						imgstr=this.codeDonyImgByPath(this.icon.minusBottom,node.id);						
					}else{
						imgstr=this.codeDonyImgByPath(this.icon.plusBottom,node.id);
					}							
				}
			}else{
				if(node.booleanLeaf==true){
					imgstr=this.codeStaticImgByPath(this.icon.join);
				}else{
					 node.cloBtnImg=this.icon.plus;
					 node.opnBtnImg=this.icon.minus;
					if(node.booleanOpen==true){
						imgstr=this.codeDonyImgByPath(this.icon.minus,node.id);//
					}else{
						imgstr=this.codeDonyImgByPath(this.icon.plus,node.id);//
					}								
				}											
			}
		}else{
				if(node.booleanLeaf==true){
					imgstr=this.codeStaticImgByPath(this.icon.empty);
				}else{
					 node.cloBtnImg=this.icon.nlPlus;
					 node.opnBtnImg=this.icon.nlMinus;					
					if(node.booleanOpen==true){
						imgstr=this.codeDonyImgByPath(this.icon.nlMinus,node.id);
					}else{
						imgstr=this.codeDonyImgByPath(this.icon.nlPlus,node.id);
					}								
				}										
		}
		return imgstr;
	}
	
	//init node margin img
	TableTree4J.prototype.codeNodeMarginImg=function(pnode){
		var imgstr="";
		if(this.config.useLine==true){
			if(pnode.booleanLastNode==true){
				imgstr=this.codeStaticImgByPath(this.icon.empty);
			}else{
				imgstr=this.codeStaticImgByPath(this.icon.line);
			}
		}else{
			imgstr=this.codeStaticImgByPath(this.icon.empty);
		}
		return 	imgstr;	
	}
	
	//init node TR
	TableTree4J.prototype.codeNodeTR=function(node){//changeClassName
		var str="";
		var changeClassMark="";
		if(this.config.booleanHighLightRow==true&&node.booleanRoot==false){
			if(node.classStyle!=null&&node.classStyle!=""){
				changeClassMark="onmouseover=\"changeClassName(this,'"+this.config.highLightRowClassName+"')\" onmouseout=\"changeClassName(this,'"+node.classStyle+"')\"";
		    }else{
				changeClassMark="onmouseover=\"changeClassName(this,'"+this.config.highLightRowClassName+"')\" onmouseout=\"changeClassName(this,'')\"";
			}
		}
		
		if(node.classStyle!=null&&node.classStyle!=""){
			str = "<tr "+changeClassMark+" id=\""+this.obj+"Trid"+node.id+"\" class=\""+node.classStyle+"\" style=\"display:"+node.visible+"\" >";			
		}else{
			str= "<tr "+changeClassMark+" id=\""+this.obj+"Trid"+node.id+"\" style=\"display:"+node.visible+"\" >";		
		}
		return str;		
	}			
	//find a node by id
	TableTree4J.prototype.findTreeNodeById=function(id){
		var nods=this.treeNodes;
		if(nods.length>0){
			for(var i=0;i<nods.length;i++){
				if(nods[i].id==id){
					return nods[i];
				}
			}
			return null;
		}else{
			return null;
		}
	}
	
	//find a node by map id
	TableTree4J.prototype.findTreeNodeByMapId=function(id){
		return this.map.get("treNod"+id);///////////////
	}	
	
	//find childs by node
	TableTree4J.prototype.findChildsToPnode=function(pnode){
		var nods=this.treeNodes;
		var childs=[];
		if(nods.length>0){
			for(var i=0;i<nods.length;i++){
				if(nods[i].pid==pnode.id){
					childs[childs.length]=nods[i];
					nods[i].pNode=pnode;
					nods[i].level=pnode.level+1;
				}
			}
			if(childs.length>0){	
		  		pnode.childNodes=childs;
				if(this.config.inOrder==true){
		  			pnode.childNodes.sort(this.nodeSortByOrder);
		  			
				}
				var lastnum=childs.length-1;
				pnode.childNodes[lastnum].booleanLastNode=true;
		  	}else{
				pnode.booleanLeaf=true;
			}
		}else{
		pnode.booleanLeaf=true;	
		}	
		return childs;				
	}
	
	
	
	//flow the nodes
	TableTree4J.prototype.flowInitChildNodes=function(pnode){
		//this.map.put("treNod"+pnode.id,pnode);
		var nods=pnode.childNodes;
		if(nods.length>0){
			for(var i=0;i<nods.length;i++){
				var childNodes=this.findChildsToPnode(nods[i]);
				nods[i].htmlcode=this.dataChangeToHtmlCode(nods[i]);				
				var nodeimgs=this.codeNodeImg(nods[i]);
				if(pnode.visible==""&&pnode.booleanOpen==true){
					nods[i].visible="";	
				}		
				var pnod2=nods[i].pNode;
				var j=0;
				if(this.config.rootNodeBtn==false){
					j=1;
				}		
				for(j;j<nods[i].level;j++){									
					nodeimgs=this.codeNodeMarginImg(pnod2)+nodeimgs;
					pnod2=pnod2.pNode;					
				}

				if(this.config.useIcon==true){
					nods[i].htmlcode=this.codeNodeIcon(nods[i])+nods[i].htmlcode;
				}
				
				nods[i].htmlcode=nodeimgs+nods[i].htmlcode;
				nods[i].htmlcode=this.codeNodeTR(nods[i])+"<td class=\""+this.config.treeStyle+"\">"+nods[i].htmlcode;
				this.htmlCode=this.htmlCode+nods[i].htmlcode;			
				if(childNodes.length>0){
					this.flowInitChildNodes(nods[i]);
				}	
			}
		}
		
	}	
	

	//node data change to html code
	TableTree4J.prototype.dataChangeToHtmlCode=function(node){
		
		var str="";
		var tipTitleMark="";
		var hrefStatusTextMark="";
		if(this.config.showTipTitle==true&&node.hrefTip!=null&&node.hrefTip!=""){
			tipTitleMark="title=\""+node.hrefTip+"\"";
		}
		if(this.config.showStatusText==true&&node.hrefStatusText!=null&&node.hrefStatusText!=""){
			hrefStatusTextMark=" onmouseover=\"window.status='"+node.hrefStatusText+"';return true;\"  onmouseout=\"window.status=' ';return true;\" ";
		}
		if(this.config.showStatusText==true&&(node.hrefStatusText==null||node.hrefStatusText=="")){
			hrefStatusTextMark="";
		}
		if(this.config.showStatusText==false){
			hrefStatusTextMark=" onmouseover=\"window.status=' ';return true;\"  onmouseout=\"window.status=' ';return true;\" ";
		}							
		if(node.booleanRoot==false){
			var fouceClearMark="";
			
			if(this.config.hrefOnfouceLine==false){
				fouceClearMark="onfocus=\"this.blur()\"";
			}						
			if(node.url!=null&&node.url!=""){
				var tg="";
				if(node.target!=null&&node.target!=""){
					tg="target=\""+node.target+"\"";
				}
				if(this.config.nodeHrefSelectBg==true){
					str="<a "+fouceClearMark+" "+tipTitleMark+" "+hrefStatusTextMark+" id=\""+this.obj+"MenuHref"+node.id+"\" onclick=\""+this.obj+".menuNodeHrefClick('"+this.obj+"MenuHref"+node.id+"')\" class=\"\" href=\""+node.url+"\" "+tg+">"+node.dataList[0]+"</a>";
				}else{
					str="<a "+fouceClearMark+" "+tipTitleMark+" "+hrefStatusTextMark+"  href=\""+node.url+"\" "+tg+">"+node.dataList[0]+"</a>";
				}
			}else{
				if(node.booleanLeaf==false&&this.config.folderAutoUrl==true){
					str="<a "+fouceClearMark+"  "+tipTitleMark+" "+hrefStatusTextMark+"   href=\"javascript:clickNode('"+node.id+"',"+this.obj+")\">"+node.dataList[0]+"</a>";
				}
				if(this.config.folderAutoUrl==false||(this.config.folderAutoUrl==true&&node.booleanLeaf==true)){
					str=node.dataList[0];
				}			
			}
		}else{	
			str="<a onfocus=\"this.blur()\"  "+tipTitleMark+" "+hrefStatusTextMark+"   href=\"javascript:clickNode('"+node.id+"',"+this.obj+")\">"+node.dataList[0]+"</a>";
		}
		
		str=str+"</td>";
		if(node.dataList.length>1){
			//col style	
			var clostyleMark="";
			if(node.booleanRoot==true&&this.headerWidthList!=null){
				for(var i=1;i<node.dataList.length;i++){
					if(this.gridHeaderColStyleArray[i]!=null&&this.gridHeaderColStyleArray[i]!=""){
						clostyleMark="class=\""+this.gridHeaderColStyleArray[i]+"\"";
					}
					str=str+"<td "+clostyleMark+" width=\""+this.headerWidthList[i]+"\">"+node.dataList[i]+"</td>"
					clostyleMark="";
				}					
			}else{
				for(var i=1;i<node.dataList.length;i++){
					if(this.gridDataCloStyleArray[i]!=null&&this.gridDataCloStyleArray[i]!=""){
						clostyleMark="class=\""+this.gridDataCloStyleArray[i]+"\"";
					}					
					str=str+"<td "+clostyleMark+" >"+node.dataList[i]+"</td>"
					clostyleMark="";
				}			
			}
			str=str+"</tr>";
		}
		return str;
	}
	
	//node sort function
	TableTree4J.prototype.nodeSortByOrder=function(a,b){
		if(parseInt (a.order)>parseInt (b.order)){
			return 1;
		}else{
			return -1;
		}
	}	
	
	//open all node
 	TableTree4J.prototype.openAllNodes=function(){
		if(this.rootNode.booleanLeaf==false){
			this.rootNode.booleanOpen=true;
			if(this.config.rootNodeBtn==true){
				var btnNodeImg=document.getElementById(this.obj+"Nodimg"+this.rootNode.id);
				btnNodeImg.src=this.rootNode.opnBtnImg;
			}
			if(this.config.useIcon==true){
				var imgNode=document.getElementById(this.obj+"ImgNod"+this.rootNode.id);
				imgNode.src=this.rootNode.iconOpen;
			}
			this.flowAllNodesOpenOrClose(true,this.rootNode);
		}
	}

	//close all node
 	TableTree4J.prototype.closeAllNodes=function(){			
			this.flowAllNodesOpenOrClose(false,this.rootNode);	
	}	
	
	
	
	//flow open all or close all
 	TableTree4J.prototype.flowAllNodesOpenOrClose=function(booleanOpenCloseAll,node){
		var childNodes=node.childNodes;
		if(booleanOpenCloseAll==true){//open
		
			//cookie
			if(this.config.useCookies==true){
				openNodeCookieMark(node.id,this);
			}		
		
			for(var i=0;i<childNodes.length;i++){
				childNodes[i].visible="";
				var nodeTR=document.getElementById(this.obj+"Trid"+childNodes[i].id);
				nodeTR.style.display=childNodes[i].visible;
				if(childNodes[i].booleanLeaf==false){
				    childNodes[i].booleanOpen=true;
				    var btnNodeImg=document.getElementById(this.obj+"Nodimg"+childNodes[i].id);
				    btnNodeImg.src=childNodes[i].opnBtnImg;
				if(this.config.useIcon==true){
					var imgNode=document.getElementById(this.obj+"ImgNod"+childNodes[i].id);
					imgNode.src=childNodes[i].iconOpen;
				}					
					
					this.flowAllNodesOpenOrClose(booleanOpenCloseAll,childNodes[i]);
				}
			}
		}else{//close
			//cookie			
			if(this.config.useCookies==true&&node.booleanOpen==false){
				closeNodeCookieMark(node.id,this);
			}	
		
			for(var i=0;i<childNodes.length;i++){
				if(node.booleanOpen==false){
					childNodes[i].visible="none";
				}
				childNodes[i].booleanOpen=false;
					var nodeTR=document.getElementById(this.obj+"Trid"+childNodes[i].id);
					nodeTR.style.display=childNodes[i].visible;					
				if(childNodes[i].booleanLeaf==false){
					var btnNodeImg=document.getElementById(this.obj+"Nodimg"+childNodes[i].id);
					btnNodeImg.src=childNodes[i].cloBtnImg;	
				if(this.config.useIcon==true){
					var imgNode=document.getElementById(this.obj+"ImgNod"+childNodes[i].id);
					imgNode.src=childNodes[i].icon;
				}								
					this.flowAllNodesOpenOrClose(booleanOpenCloseAll,childNodes[i]);
				}
			}	
		}
	}	
		
	//init root node
	TableTree4J.prototype.initRootNode=function(){
		var allNodes=this.treeNodes;
		var rootNod=this.rootNode;
		var codes=this.codeNodeTR(rootNod);
		if(this.headerWidthList!=null&&this.headerWidthList!=""){
			codes=codes+"<td width=\""+this.headerWidthList[0]+"\">"
		}else{
			codes=codes+"<td>";
		}
				
		if(allNodes.length>0){
			var dImgcode="";
			this.findChildsToPnode(rootNod);
			dImgcode=this.codeNodeImg(rootNod);
			if(rootNod.childNodes.length==0){
				dImgcode="";
			}
			codes=codes+dImgcode;
		}else{
			rootNod.booleanLeaf=true;			
		}
		if(this.config.useIcon==true){
			codes=codes+this.codeNodeIcon(rootNod);
		}		
		rootNod.htmlcode=codes+this.dataChangeToHtmlCode(rootNod);
		this.htmlCode=this.htmlCode+rootNod.htmlcode;
		
	}
	
	TableTree4J.prototype.removeTreeCookies=function(){
		removeCookie(this.obj+"openId");
		removeCookie(this.obj+"closeId");
	}
	
	//init all node
	TableTree4J.prototype.initNodes=function(){
		var allNodes=this.treeNodes;
		var rootNod=this.rootNode;
		this.initRootNode();
		if(allNodes.length>0&&rootNod.booleanLeaf==false){
			this.flowInitChildNodes(rootNod);
		}
		//cookie
		if(this.config.useCookies==false){
			this.removeTreeCookies();
		}else{
			clearNoUseCookieMark(this);
		}
	}
	
	
	
	
}


//Data Value Object
function Node(dataList,id,pid,booleanOpen,order,url,target,classStyle,icon,iconOpen,hrefTip,hrefStatusText){

	this.dataList=dataList;
	this.id=id||-1;
	this.pid=pid||this.id;
	this.name=dataList[0];
	this.order=order;
	this.icon=icon;
	this.iconOpen=iconOpen;
	this.classStyle=classStyle;
	this.url=url;
	this.target=target;
	this.hrefStatusText=hrefStatusText;
	this.booleanOpen=booleanOpen;//||tree.config.booleanInitOpenAll;
	this.hrefTip=hrefTip;
	this.childNodes;
	this.pNode;
	this.level;
	
	this.visible="none";
	this.cloBtnImg;
	this.opnBtnImg;
	
	this.booleanRoot=false;
	this.booleanLeaf=false;
	this.booleanLastNode=false;
	this.htmlcode;
}

//HashMap Obj
function HashMap(){
	
	HashMap.prototype.put=function(key,value){
   		try 	{
        	key = "_" + key.toString();
        	if (this[key] == null) {
            	 this[key] = value;
        	}
    	} catch(e) { return false; }
    	return true;		
	}
	
	HashMap.prototype.get=function(key){
   		var value = null;
    	try {
       	 key = "_" + key.toString();
        	if (this[key]) value = this[key];
   	 } catch(e) {return null;}
    	return value	
	}
	
}


//click a node even
function clickNode(nodeid,tree){

	var clickNode = tree.findTreeNodeByMapId(nodeid);
	if(clickNode.booleanLeaf==false){
		var clickNodeImg;
		if(clickNode.booleanRoot==false||(clickNode.booleanRoot==true&&tree.config.rootNodeBtn==true)){
			clickNodeImg=document.getElementById(tree.obj+"Nodimg"+nodeid);
		}
		var clickImgNode="";
		if(tree.config.useIcon==true){
			clickImgNode=document.getElementById(tree.obj+"ImgNod"+nodeid);
		}
		if(clickNode.booleanOpen==true){
			clickNode.booleanOpen=false;
			//cookie
			if(tree.config.useCookies==true){
				closeNodeCookieMark(nodeid,tree);
			}			
			if(clickNode.booleanRoot==false||(clickNode.booleanRoot==true&&tree.config.rootNodeBtn==true)){
				clickNodeImg.src=clickNode.cloBtnImg;
			}
			if(tree.config.useIcon==true){clickImgNode.src=clickNode.icon;}
		}else{
			clickNode.booleanOpen=true;
			//cookie
			if(tree.config.useCookies==true){
				openNodeCookieMark(nodeid,tree);
			}	
					
			if(clickNode.booleanRoot==false||(clickNode.booleanRoot==true&&tree.config.rootNodeBtn==true)){
				clickNodeImg.src=clickNode.opnBtnImg;
			}
			if(tree.config.useIcon==true){clickImgNode.src=clickNode.iconOpen;}
		}				
		flowChildNodesByClickPnode(clickNode,tree.obj);
	}	
}


//after click the node , flow to init the child node
function flowChildNodesByClickPnode(node,treeObjName){
	var childNodes=node.childNodes;
	//close
		if(node.booleanOpen==false||(node.booleanOpen==true&&node.visible=="none")){
			for(var i=0;i<childNodes.length;i++){
				childNodes[i].visible="none";
				var nodeTR=document.getElementById(treeObjName+"Trid"+childNodes[i].id);
				nodeTR.style.display=childNodes[i].visible;				
				if(childNodes[i].booleanLeaf==false){			
					flowChildNodesByClickPnode(childNodes[i],treeObjName);
				}
			}
		}else{//open
			if(node.visible==""){
				for(var i=0;i<childNodes.length;i++){
					childNodes[i].visible="";
					var nodeTR=document.getElementById(treeObjName+"Trid"+childNodes[i].id);
					nodeTR.style.display=childNodes[i].visible;						
					if(childNodes[i].booleanLeaf==false){			
						flowChildNodesByClickPnode(childNodes[i],treeObjName);
					}	
				}		 	
			}
		}
}

function changeClassName(objectChange,classN){
	objectChange.className=	classN;
}

function clearNoUseCookieMark(tree){
	var openids=getCookie(tree.obj+"openId");
	if(openids!=null&&openids!=""){
		var opidArray=openids.split("T");
		var node=null;
		for(var i=0;i<opidArray.length;i++){
			if(opidArray[i]!=""){
				node=tree.findTreeNodeByMapId(opidArray[i]);
				if(node==null||node.booleanLeaf==true){
					openCookieRemoveMarkId(opidArray[i],tree);
				}
			}
		}
	}
	
	var closeids=getCookie(tree.obj+"closeId");
	if(closeids!=null&&closeids!=""){
		var cloidArray=closeids.split("T");
		var node=null;
		for(var i=0;i<cloidArray.length;i++){
			if(cloidArray[i]!=""){
				node=tree.findTreeNodeByMapId(cloidArray[i]);
				if(node==null||node.booleanLeaf==true){
					closeCookieRemoveMarkId(cloidArray[i],tree);
				}
			}
		}
	}	
		
}

function openNodeCookieMark(id,tree){
	closeCookieRemoveMarkId(id,tree);
	var openids=getCookie(tree.obj+"openId");
	if(openids==null||openids==""){
		setCookie(tree.obj+"openId","T"+id+"T",tree.config.cookieTime);
	}else{
		if(openids.indexOf("T"+id+"T")==-1){
			openids=openids+id+"T";
			setCookie(tree.obj+"openId",openids,tree.config.cookieTime);
		}	
	}
}

function closeNodeCookieMark(id,tree){
	openCookieRemoveMarkId(id,tree);
	var closeids=getCookie(tree.obj+"closeId");
	if(closeids==null||closeids==""){
		setCookie(tree.obj+"closeId","T"+id+"T",tree.config.cookieTime);
	}else{
		if(closeids.indexOf("T"+id+"T")==-1){
			closeids=closeids+id+"T";
			setCookie(tree.obj+"closeId",closeids,tree.config.cookieTime);
		}	
	}
	
}

function openCookieRemoveMarkId(id,tree){
	var openids=getCookie(tree.obj+"openId");
	if(openids!=null){
		if(openids.indexOf("T"+id+"T")!=-1){
			openids=openids.replace("T"+id+"T","T");
			setCookie(tree.obj+"openId",openids,tree.config.cookieTime);
		}
	}	
}

function closeCookieRemoveMarkId(id,tree){
	var closeids=getCookie(tree.obj+"closeId");
	if(closeids!=null){
		if(closeids.indexOf("T"+id+"T")!=-1){
			closeids=closeids.replace("T"+id+"T","T");
			setCookie(tree.obj+"closeId",closeids,tree.config.cookieTime);
		}
	}	
}

function booleanNodeInOpenCookie(id,tree){
	var openids=getCookie(tree.obj+"openId");
	var closeids=getCookie(tree.obj+"closeId");
	if(openids==null&&closeids==null){
		return 0;
	}else{
		if(openids!=null&&openids.indexOf("T"+id+"T")!=-1){
			return 1;	
		}
		if(closeids!=null&&closeids.indexOf("T"+id+"T")!=-1){
			return 2;	
		}		
	}
	return 0;
}

function setCookie(name,value,timeSet){
	var time =timeSet
	if(time==null||time==""){
		time=30*24*60*60*1000;
	}
  	var exp  = new Date();
	exp.setTime(exp.getTime() + time);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();	
}

function getCookie(cookieName){
   	var cookieString = document.cookie;
	
	//var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));	
   	var start = cookieString.indexOf(cookieName + '=');
   	if (start == -1){
     	return null;
		} 
   	start += cookieName.length + 1;
   	var end = cookieString.indexOf(';', start);
   	if (end == -1) return unescape(cookieString.substring(start));
   	return unescape(cookieString.substring(start, end));	
}

function removeCookie(name){
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval=getCookie(name);
	if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();	
}

function removeAllCookie(){
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cookieString=document.cookie;
	var cookiesArray=cookieString.split("; ");
	if(cookiesArray.length!=0&&cookiesArray[0]!=""){
		for(var i=0;i<cookiesArray.length;i++){
			document.cookie= cookiesArray[i]+";expires="+exp.toGMTString();
		}
	}
	
		
}
