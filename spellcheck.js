Request.SpellCheck = new Class({

       Extends: Request.JSON,

       options: {
          url: 'spellcheck.php',
          method: 'post',
        
          //characteristic features spell checker
          lang: 'en',
          ignoredigits: false,
          ignoreallcaps: false   
      }, 

      spellcheck: function(text) {
          this.text = text; 
          this.send({
               data:{
                    lang: this.options.lang,
                    ignoredigits: this.options.ignoredigits,
                    ignoreallcaps: this.options.ignoreallcaps,
                    text: text
                    }
          }); 
      },

      setLang: function(lang) {

        this.options.lang = lang;
      },

      analyseSuggestions: function(text, spellCheckResult) {

        var data = [], i = 0; 

        $each(spellCheckResult, function(row){

              data.push({
                   text: text.substr(row.o,row.l),
                   suggestions: row.a,
                   valid: false
              });  

        }); 

        return data;
     },

     success: function(text) {
        this.response.json = JSON.decode(text);
        this.response.suggestions = this.analyseSuggestions(this.text, this.response.json);
        this.onSuccess(this.response.suggestions, this.response.json, text, this.text);
     }
});