<?xml version="1.0" encoding="UTF-8"?>
<playlist version="1" xmlns="http://xspf.org/ns/0/">
   <trackList>
{{section name='list' loop=$PLAYLIST}}
      <track>
         <location>{{LINK section=$PLAYLIST[list].uri page=$smarty.get.playlist script='player'}}</location>
         <creator>{{$PHPBB_USERNAME|default:$SITENAME}}</creator>
         <title>{{$PLAYLIST[list].title}}</title>
         <annotation>{{$PLAYLIST[list].title}}</annotation>
         <image>{{LINK script='video_thumb' section=$PLAYLIST[list].uri}}</image>
         <info>{{LINK section=$PLAYLIST[list].uri page=$smarty.get.playlist script='player'}}</info>
      </track>
{{/section}}
   </trackList>
</playlist>
