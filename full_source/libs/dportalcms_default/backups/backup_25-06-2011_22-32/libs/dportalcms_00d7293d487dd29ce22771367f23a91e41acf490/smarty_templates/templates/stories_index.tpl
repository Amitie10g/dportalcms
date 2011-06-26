<h1>{{$TITLE}}</h1>
{{DYNAMIC}}
{{if $smarty.session.AUTHOR_NOT_EXIST}}<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.author_not_exist|ucfirst}}</div>{{/if}}
{{if $smarty.session.BOOK_NOT_CREATED}}
<div style="border:1px #000000 dotted; padding:5px; width:390px;background:#FFAAAA;text-align:center;margin:5px auto;font-size:14px">{{$LANG.create_book_error|ucfirst}}</div>{{/if}}
{{if $smarty.session.SEARCH_EXACT_RESULT}}<div id="item_1" style="border:1px #000000 dotted; padding:5px; width:400px;background:#AAFFAA;text-align:center;margin:5px auto;font-size:14px">
<p style="font-weight:bold;margin:2px">This is the exact result of your search.</p>
<p>Not that your expected? Try using the <a href="{{LINK script='books_search'}}">Advanced search</a></p>
<p style="text-align:right;margin:0;cursor:pointer" onclick="items(1)">Close</p>
</div>{{/if}}
{{/DYNAMIC}}

{{if !empty($BOOKS_PUBLISHED)}}
<div style="width:auto;max-width:600px;padding:3px;border:#000000 1px dashed;margin:auto;text-align:center">

<div style="display:inline-table;margin:auto;border:#000000 1px dotted">

<span style="padding:0;font-size: 19px;float:left;text-align:right;"><span style="letter-spacing:8px;margin-right:-5px">Books</span><br />published</span>


<span style="padding:0;margin-top:-8px;font-size: 50px;float:right">:{{$BOOKS_PUBLISHED}}</span>
</div>

<div style="display:inline-table;margin:auto;border:#000000 1px dotted" title="Total points: {{$POINTS}}">
<span style="margin-top:-8px;padding:0;font-size: 50px;float:left;text-align:right">Points:</span>
<span style="margin-top:-8px;padding:0;font-size: 50px;float:right">{{if $POINTS < 10000}}{{$POINTS}}
{{elseif $POINTS >= 10000 && $BOOKS[books].points < 100000}}<img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_c.png" width="45px" title="Rank C: {{$POINTS}} pts" style="margin-top:5px;margin-bottom:-5px"/>
{{elseif $POINTS >= 100000 && $BOOKS[books].points < 500000}}<img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_b.png" width="{{if $BOOKS_PUBLISHED >= 10}}65{{else}}62{{/if}}px" title="Rank B: {{$POINTS}} pts" />
{{elseif $POINTS >= 500000 && $BOOKS[books].points < 1000000}}<img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_a.png" width="{{if $BOOKS_PUBLISHED >= 10}}65{{else}}62{{/if}}px" title="Rank A: {{$POINTS}} pts" />
{{elseif $POINTS >= 1000000}}<img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_s.png" width="50px" title="Rank S: {{$POINTS}} pts" style="margin-top:5px" />{{/if}}</span>
</div>

</div>
<div style="clear:left"></div>

{{/if}}

{{section name="books" loop=$BOOKS}}
<div style="max-width:600px;border:1px #000000 dotted;margin:10px auto;padding:3px">
<div style="display:inline-table;max-width:84%">
<h2 style="margin:0;font-size:15px;{{if $ALLOWED_EDIT}}float:left{{/if}}"><a href="{{LINK script="chapter" section="1" page=$BOOKS[books].name argument=$BOOKS[books].author}}">{{$BOOKS[books].title}}</a></h2>{{if $ALLOWED_EDIT}} <span style="font-size:8px">({{$BOOKS[books].reads|default:"No"}} {{$LANG.reads}}reads)</span>{{/if}}
<p style="margin:5px 10px">{{$BOOKS[books].summary}}</p>
<p style="margin:5px 0"><span style="font-weight:bold">{{$LANG.author|ucfirst}}:</span> <a href="{{LINK script="books_filter_author" section=$BOOKS[books].author|get_user}}" title="{{$LANG.see_stories_author}}">{{$BOOKS[books].author|get_user}}</a>{{DYNAMIC}}{{if $USE_PHPBB && $LOGED_IN}} [<a href="{{$PHPBB_URL_PATH}}memberlist.php?mode=viewprofile&u={{$BOOKS[books].author}}" rel="external"  title="{{$LANG.view_profile|ucfirst}}">{{$LANG.profile|ucfirst}}</a>] [<a href="{{$PHPBB_URL_PATH}}ucp.php?i=pm&mode=compose&u={{$BOOKS[books].author}}" rel="external"  title="{{$LANG.send_private_message|ucfirst}}">{{$LANG.private_message|ucfirst}}</a>]{{/if}}{{/DYNAMIC}}</p>
</div>
<div style="display:inline-table;width:70px;float:right;text-align:center;vertical-align:middle">
{{if $BOOKS[books].points < 1000}}
<span style="font-size:40px">{{$BOOKS[books].points}}</span><br />{{if $BOOKS[books].points == 1}}Point{{else}}points{{/if}}
{{elseif $BOOKS[books].points >= 1000 && $BOOKS[books].points < 10000}}
<span style="font-size:30px">{{$BOOKS[books].points}}</span><br />{{if $BOOKS[books].points == 1}}Point{{else}}points{{/if}}
{{elseif $BOOKS[books].points >= 10000 && $BOOKS[books].points < 100000}}
<span><img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_c.png" width="70px" title="Rank C: {{$BOOKS[books].points}} pts" /></span>
{{elseif $BOOKS[books].points >= 100000 && $BOOKS[books].points < 500000}}
<span><img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_b.png" width="70px" title="Rank B: {{$BOOKS[books].points}} pts" /></span>
{{elseif $BOOKS[books].points >= 500000 && $BOOKS[books].points < 1000000}}
<span><img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_a.png" width="70px" title="Rank A: {{$BOOKS[books].points}} pts" /></span>
{{elseif $BOOKS[books].points >= 1000000}}
<span><img src="{{$smarty.const.DPORTAL_PATH}}/images/rank_s.png" width="70px" title="Rank S: {{$BOOKS[books].points}} pts" /></span>
{{* Rank C: > 10.000; Rank B: > 100.000; Rank A: > 500.000; Rank S > 1.000.000 *}}
{{/if}}
</div>
</div>
{{sectionelse}}
<div><p style="font-size:14px;font-style:italic;text-align:center">Sorry, but currently no Stories has been published.{{if $LOGED_IN}} Create one now!{{/if}}</p></div>
{{/section}}

