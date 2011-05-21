<h1>{{$TITLE}}</h1>

{{section name="chapters" loop=$CHAPTERS}}
<h2>{{$LANG.chapter|ucfirst}} {{$CHAPTERS[chapters].name}}: {{$CHAPTERS[chapters].title}}</h2>
{{fetch2 file=$CHAPTERS[chapters].file}}
<hr />
{{/section}}

