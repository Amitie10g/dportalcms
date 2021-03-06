/* This CSS file is generated dinamically, but major contents are static.*/

body{
	font-size:{{$STYLE_CONF.body_font_size.value}};
	padding:0 {{$STYLE_CONF.body_padding.value}}px;
	background:{{if !empty($STYLE_CONF.body_background.value.color)}}#{{$STYLE_CONF.body_background.value.color}}{{/if}}{{if !empty($STYLE_CONF.body_background.value.url)}} url({{$STYLE_CONF.body_background.value.url}}){{/if}}{{if !empty($STYLE_CONF.body_background.value.params)}} {{$STYLE_CONF.body_background.value.params}}{{/if}};
	font-family:{{$STYLE_CONF.body_font_family.value}};
	color:#{{$STYLE_CONF.body_font_color.value}};
}

a:link{
	text-decoration:none;
	font-weight:bold;
	color:#{{$STYLE_CONF.a_link_color.value}};
	
}a:visited{
	text-decoration: none;
	font-weight: bold;
	color:#{{$STYLE_CONF.a_visited_color.value}};
}a:hover{
	text-decoration:none;
	font-weight:bold;
	color:#{{$STYLE_CONF.a_hover_color.value}};

}.sidebar_link{
	margin-bottom: 5px;

}em.desc{
	font-size:11px;
}#container{
	width:{{$STYLE_CONF.container_width.value.width}}{{if $STYLE_CONF.container_width.value.mode == 'px' || $STYLE_CONF.container_width.value.mode == '%'}}{{$STYLE_CONF.container_width.value.mode}}{{/if}};
	border:{{if !empty($STYLE_CONF.container_border.value.color) && $STYLE_CONF.container_border.value.type != 'none'}}#{{$STYLE_CONF.container_border.value.color}}{{/if}}{{if !empty($STYLE_CONF.container_border.value.size)}} {{$STYLE_CONF.container_border.value.size}}px{{/if}}{{if !empty($STYLE_CONF.container_border.value.type)}} {{$STYLE_CONF.container_border.value.type}}{{/if}};
	margin:{{$STYLE_CONF.container_margin.value}}px;
	padding:{{$STYLE_CONF.container_padding.value}}px;
	background:{{if !empty($STYLE_CONF.container_background.value.color)}}#{{$STYLE_CONF.container_background.value.color}}{{/if}}{{if !empty($STYLE_CONF.container_background.value.url)}} url({{$STYLE_CONF.container_background.value.url}}){{/if}}{{if !empty($STYLE_CONF.container_background.value.params)}} {{$STYLE_CONF.container_background.value.params}}{{/if}};
}#banner{
	width:{{$STYLE_CONF.banner_width.value.width}}{{if $STYLE_CONF._banner_width.value.mode == 'px' || $STYLE_CONF._banner_width.value.mode == '%'}}{{$STYLE_CONF._banner_width.value.mode}}{{/if}};
	margin:{{$STYLE_CONF._banner_margin.value}}px;
	border:{{if !empty($STYLE_CONF._banner_border.value.color) && $STYLE_CONF._banner_border.value.type != none}}#{{$STYLE_CONF._banner_border.value.color}}{{/if}}{{if !empty($STYLE_CONF._banner_border.value.size)}} {{$STYLE_CONF._banner_border.value.size}}px{{/if}}{{if !empty($STYLE_CONF._banner_border.value.type)}} {{$STYLE_CONF._banner_border.value.type}}{{/if}};
}.banner{
	width:{{$STYLE_CONF.banner_width.value.width}}{{if $STYLE_CONF.banner_width.value.mode == 'px' || $STYLE_CONF.banner_width.value.mode == '%'}}{{$STYLE_CONF.banner_width.value.mode}}{{/if}};
	height: 150px;
	border:{{if !empty($STYLE_CONF.banner_border.value.color) && $STYLE_CONF.banner_border.value.type != none}}#{{$STYLE_CONF.banner_border.value.color}}{{/if}}{{if !empty($STYLE_CONF.banner_border.value.size)}} {{$STYLE_CONF.banner_border.value.size}}px{{/if}}{{if !empty($STYLE_CONF.banner_border.value.type)}} {{$STYLE_CONF.banner_border.value.type}}{{/if}};
	text-align: center;
	margin:5px;
	background:{{if !empty($STYLE_CONF.banner_background.value.color)}}#{{$STYLE_CONF.banner_background.value.color}}{{/if}}{{if !empty($STYLE_CONF.banner_background.value.url)}} url({{$STYLE_CONF.banner_background.value.url}}){{/if}}{{if !empty($STYLE_CONF.banner_background.value.params)}} {{$STYLE_CONF.banner_background.value.params}}{{/if}};
}#sup_ads{
	width:99%;
	margin:0 auto;
	border:2px #000 dashed;
}.sup_ads{
	width:auto;
	text-align:center;
	/*border:1px #000 dashed;*/
	/*margin:5px auto;*/
}h1{
	font-size:{{$STYLE_CONF.h1_font_size.value}};
	margin:0 0 10px 0;
	text-align:center;
	
}h2{
	font-size:{{$STYLE_CONF.h2_font_size.value}};

}h3{
	font-size:{{$STYLE_CONF.h3_font_size.value}};

}h5.titre{
  font-size:13px;
  font-family:Verdana,sans-serif;
  background:#94D4FC url(images/fond2.gif);
  border:#4474BC 1px solid;
  margin:0;
  color:#4D73AD;
  padding:2px;
  text-align:center;

}.sidebar{
	width: {{$STYLE_CONF.sidebar_width.value.width}}{{$STYLE_CONF.sidebar_width.value.mode}};
	min-height:100px;
	border:{{if !empty($STYLE_CONF.sidebar_border.value.color) && $STYLE_CONF.sidebar_border.value.type != none}}#{{$STYLE_CONF.sidebar_border.value.color}}{{/if}}{{if !empty($STYLE_CONF.sidebar_border.value.size)}} {{$STYLE_CONF.sidebar_border.value.size}}px{{/if}}{{if !empty($STYLE_CONF.sidebar_border.value.type)}} {{$STYLE_CONF.sidebar_border.value.type}}{{/if}};
	margin: 0 0 5px 0;
	float:{{$STYLE_CONF.sidebar_float.value}};
	padding:0px;
	font-size:{{$STYLE_CONF.sidebar_font_size.value}};
	background:{{if !empty($STYLE_CONF.sidebar_background.value.color)}}#{{$STYLE_CONF.sidebar_background.value.color}}{{/if}}{{if !empty($STYLE_CONF.sidebar_background.value.url)}} url({{$STYLE_CONF.sidebar_background.value.url}}){{/if}}{{if !empty($STYLE_CONF.sidebar_background.value.params)}} {{$STYLE_CONF.sidebar_background.value.params}}{{/if}};
	padding-bottom:10px !important; /* To adjust with .content that has a a div block with a clear statement */ 
}.content{
	width:auto;
	min-height:100px;
	border:{{if !empty($STYLE_CONF.content_border.value.color) && $STYLE_CONF.content_border.value.type != none}}#{{$STYLE_CONF.content_border.value.color}}{{/if}}{{if !empty($STYLE_CONF.content_border.value.size)}} {{$STYLE_CONF.content_border.value.size}}px{{/if}}{{if !empty($STYLE_CONF.content_border.value.type)}} {{$STYLE_CONF.content_border.value.type}}{{/if}};
	margin:{{$STYLE_CONF.content_margin.value}};
	margin-{{$STYLE_CONF.sidebar_float.value}}: {{$STYLE_CONF.sidebar_width.value.width+6}}px;
	padding:{{$STYLE_CONF.content_padding.value}}px;
	font-size:{{$STYLE_CONF.content_font_size.value}}px;
	background:{{if !empty($STYLE_CONF.content_background.value.color)}}#{{$STYLE_CONF.content_background.value.color}}{{/if}}{{if !empty($STYLE_CONF.content_background.value.url)}} url({{$STYLE_CONF.content_background.value.url}}){{/if}}{{if !empty($STYLE_CONF.content_background.value.params)}} {{$STYLE_CONF.content_background.value.params}}{{/if}};
	color:{{$STYLE_CONF.content_font_color.value}};
}.footer{
	width:auto;
	border:{{if !empty($STYLE_CONF.footer_border.value.color) && $STYLE_CONF.footer_border.value.type != none}}#{{$STYLE_CONF.footer_border.value.color}}{{/if}}{{if !empty($STYLE_CONF.footer_border.value.size) && $STYLE_CONF.footer_border.value.type != 'none'}} {{$STYLE_CONF.footer_border.value.size}}px{{/if}} {{$STYLE_CONF.footer_border.value.type}};
	margin:{{$STYLE_CONF.footer_margin.value}};
	margin-top:5px;
	padding:{{$STYLE_CONF.footer_padding.value}}px;
	background:{{if !empty($STYLE_CONF.footer_background.value.color)}}#{{$STYLE_CONF.footer_background.value.color}}{{/if}}{{if !empty($STYLE_CONF.footer_background.value.url)}} url({{$STYLE_CONF.footer_background.value.url}}){{/if}}{{if !empty($STYLE_CONF.footer_background.value.params)}} {{$STYLE_CONF.footer_background.value.params}}{{/if}};
}ul.list{
	list-style-type:none;
	margin:0;
	padding:0;
}li.list{
	 padding:2px 0;
}ul.menu{
	list-style-type:none;
	padding:0;
	margin:0;
	font-weight:bold;
}li.menu{
	 margin:5px;
}.img{
	 border:0;
}.menu{
	text-align:center;
	margin:0 90px;

}.invisible{
	visibility:hidden;
	font-size:0;
	height:0;
	padding:0;
	margin:0;
}.cleaner{
	clear:both;
	padding:0;
	margin:0;
	height:0;
	font-size:0;
}

.image_gallery{

	display:inline-table;
	padding:5px;
	margin:5px;
	vertical-align:middle;
}

.contenidoItem p{
	 margin: 3px;
}

.blog_entry {
    border-bottom: #000000 1px dotted;;
    margin-bottom: 20px; 
}

.blog_entry_last {
    border:none;
    margin-bottom:0;
}

.blog_entry_content {
    margin:3px 0 3px 10px;
}

h2.blog_entry_title{
    margin:0;
    padding:0;
}

h3.blog_entry_date{
  font-size:10px;
  margin:0;
  padding:0;
}

.code {
  margin: 0 0 20px 50px;
  font-family:Courier New, monospaced, mono;
  background: #fff;
  max-height:400px;
  overflow:auto;
}

.message_ok, .message_error{
  font-size:16px;
  margin: 3px auto;
  max-width:400px;
  text-align:center;
  padding: 7px;
}

.message_ok {
  background: #ccffcc;
  border: #009933 1px dotted;
  color: #009933;
}

.message_error {
  background: #ff9999;
  border: #990000 1px dotted;
  color: #990000;
}

select.list{
	min-width: 200px;
}

@media print{.no_print{
	display:none;
}}

/** Searchcontrol */

/* Main box */
#searchcontrol .gsc-control{
font-size:90%;
font-weight:bold;

}

.searchcontrol{
position:relative !important;
height: 40px !important;
background: {{$STYLE_CONF.search_control_backgorund.value}};
z-index:10 !important;
padding: 5px !important;
}

/* "Loading..." text */
span.loading {
font-size:120%;
font-weight:bold;
}

/* bold the section header */
.gsc-tabHeader {
font-weight: bold !important;
color : #55AA11 !important;
font-family: Arial, sans-serif !important;
}

/* Tabs */
.gsc-tabhInactive {
background: #AAFF99 !important;
border-color: #CCFFAA #88FF77 #88FF77 #CCFFAA !important;
}

.gsc-tabhActive {
background: #DDFFCC !important;
}

/* Results */
.gsc-resultsRoot-siteSearch .gsc-keeper {
background-image : url('http://google.com/css/orange_check.gif');
font-weight : bold;
color: #55AA11;
}

.gsc-resultsRoot {
width:400px !important;
position:relative !important;
right:{{$STYLE_CONF.sidebar_width.value.width+55}}px !important;
top:-5px !important;
background: #FFFFFF !important;
border-left:1px #000000 dashed !important;
border-bottom:1px #000000 dashed !important;
border-top:1px #000000 dashed !important;
padding-left: 10px  !important;
}

.gs-title{
font-size: 11px !important;
font-family: Arial, sans-serif !important;
color:#338800 !important;
}

.gsc-results .gsc-webResult {
font-size: 10px !important;
font-family: Arial, sans-serif !important;
}

.gs-visibleUrl {
font-size: 11px !important;
font-family: Arial, sans-serif !important;
}

.gsc-tabsArea .gsc-branding-text .gs-snippet {
font-size: 0px !important;
color: #fff !important;
}

.gsc-branding-text {
font-size: 0px !important;
color: #fff !important;
width:0 !important;
height:0 !important;
}

.gsc-branding-user-defined {
width: 0 !important;
height: 0 !important;
}

.gsc-cursor-box {
font-size: 12px !important;
}

.gsc-cursor-page {
color:#44AA55 !important;
}

.gsc-trailing-more-results {
color:#11AA88 !important;
}

.gsc-input {
width: {{$STYLE_CONF.sidebar_width.value.width-40}}px !important;
}

.gsc-search-button {
padding:0 !important;
margin: 0 -5px 0 2px !important;
width: 20px;
height: 20px;
font-size: 0px;
border:0;
color:#338800 !important;
background: url({{$smarty.const.DPORTAL_PATH}}/images/20pxsearchtoolsvg.png) no-repeat !important;
}

.gsc-clear-button{
top: 10px !important;
right: 6px !important;
position:relative !important;
}

.gsc-imageResult {
margin:auto !important;
}

ul.maketree, ul.maketree ul, ul.maketree li {
  margin: 0;
  padding: 0;
  list-style-type: none;
}
ul.maketree ul { padding-left: 0.3em; }
ul.maketree li {
  border-left: 1px dotted #000;
  padding-left: 13px;
  background: url(dotted.gif) scroll no-repeat 1px 0.8em;
}
ul.maketree li.last {
  border-left-width: 0px;
  padding-left: 14px;
  background: url(dottedangle.gif) scroll no-repeat left top;
}