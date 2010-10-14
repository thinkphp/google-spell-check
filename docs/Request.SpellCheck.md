Class: Request.SpellCheck (#Request.SpellCheck)
===============================================

This class allows you to provide spell checking for text. It uses Google API to check if the text is correct and 
to get some suggestions. This is done by PHP that uses cURL to get some xml and translates it to JSON, so we can
use Request.JSON for out client-side. That is where Request.SpellCheck is build on. Request.SpellCheck will give
you an array in the onSuccess event that you can use.

Request.SpellCheck Method: constructor(#Request.SpellCheck: constructor)
--------------------------------------------------------

### Syntax: 

var spell = new Request.SpellCheck([options]);

#### Arguments:

1. options (*Object*) - All the options from Request.JSON and 

   - lang (*string* default 'en') The language code
   - ignoredigits (*boolean* default false) true to ignore digits, false to check them.
   - ignoreallcaps (*boolean* default false) true to ignore words with all caps, false to check them. 

### Returns:

A Request.SpellCheck instance

### Events:

All the events you know from Request.JSON

#### success

Fired when the request has completed. This overrides the signature of the Request.JSON success event.

#### Signature:

onSuccess(suggestions, responseJSON, responseText, text);

##### Arguments:

- suggestions (*Array*) an array with objects.
          Each object contains: 
          - text (*String*) the orignal word.
          - suggestions (*Array*) an array with suggestions from google service api
          - valid (*boolean*) default false for invalid word.
       
- responsJSON (*object*) the JSON response object from the remote request.
- responsText (*String*) the JSON response as string.
- text        (*String*) the original input text


### Request.SpellCheck Method: spellcheck (#Request.SpellCheck : spellcheck)

With this method you can perform the spelling text.

#### Syntax:
     spell.spellcheck('Thi is a testt!');    

### Request.SpellCheck Method: setLang (#Request.SpellCheck : setLang)

You can use this method to set the language.

#### Syntax:

    spel.setLang('en')

### Proof

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
