Request.SpellCheck
==================

This class allows you to provide spell checking for text. It uses Google API to check if the text is correct and 
to get some suggestions. This is done by PHP that uses cURL to get some xml and translates it to JSON, so we can
use Request.JSON for out client-side. That is where Request.SpellCheck is build on. Request.SpellCheck will give
you an array in the onSuccess event that you can use.


![Screenshot](http://farm5.static.flickr.com/4111/5070795173_f0f818dea9_z.jpg)

How to use
----------

First you must to include the JS files in the head of your HTML document.

            #HTML
            <script type="text/javascript" src="mootools.js"></script>
            <script type="text/javascript" src="spellcheck.js"></script>

In your JS.
          
           #JS
           window.addEvent('domready',function(){
                  var spell = new Request.SpellCheck({ 
                               url: 'spellcheck.php',
                               onSuccess: function(suggestions, data, response, text) {
                                       var text = text;
                                       $each(suggestions,function(suggest){
                                             var word = suggest.text;
                                             text = text.replace(word,'<span class="invalid">'+word+'</span><b> ('+suggest.suggestions.join(',')+')</b>'); 
                                       });
                                       $('spellzone').set('html',text);
                               }
                  });

                  var val = document.id('input_text'); 
                  $('spell').addEvent('click',function(){
                       if(val){
                           spell.spellcheck(val.get('value'));
                       }
                  })
           }); 
