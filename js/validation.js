app = new Vue({
  el: '#app',
  data: {
    url: '',
    alias: '',    
    token: '',
    errMsgUrl: '',
    errMsgAlias: '',    
    lead: { url: '', alias: '', token: ''},    
    btnText: true,
    loader: false,
    form: true,
    after: false,
    shortURL: '',
    base: "https://shortit.cloud/",
    focused_url: false,
    focused_alias: false,    
  },

  mounted: function () {
    this.calcToken();
  },

  methods: {

    calcToken: function(){     
      axios.get(this.base+'pro.php', {
        params: {
          req: 't',
        }
      })
        .then(function (response) {          
          app.token = response.data;          
        });
    },

    isUrlValid: function (arg) {
      if (this.url == '') {
        app.errMsgUrl = 'Your long URL here';
        return false;
      }else{
        app.errMsgUrl = '';
        this.lead.url = this.url;
        return true;
      }

    },

    copyURL: function(){
      navigator.clipboard.writeText(this.shortURL).then(function () {
          alert("copied!");
      }, function (err) {
        console.log("Error - try again");
      });      
    },

    redirectURL: function(){
      // window.location.href = this.shortURL;
      window.open(this.shortURL);      
    },

    shareWhatsapp: function(){
      window.location.href = "whatsapp://send?Check it out %0a :"+ this.shortURL;
    },

    handler: function (arg) {
      if( this.isUrlValid(arg)){
        app.sendData();
      }   

    },

    //SEND DATA
    sendData: function () {
      this.loader = true;
      this.btnText = false;      
      app.lead.url = this.url ? this.url : '';      
      app.lead.alias = this.alias ? this.alias : '';      
      app.lead.token = this.token ? this.token : '';

      let leadForm = app.toFormData(app.lead);
    
      axios.post(app.base+'short.php', leadForm, {headers: {'Content-Type': 'application/json;charset=UTF-8', "Access-Control-Allow-Origin": "*"}}).then(function (response) {

        // console.log(response.data.code);
        // console.log("jjj");
        // return;

        //@TODO - CHECK CODE NOT URL! - ERROR SECTION (CODE 0) --> RETURN msg TEXT
        if (!response.data.code) {
          app.loader = false;
          app.btnText = true; 
          app.errMsgUrl = response.data.msg; 
        }
    //@TODO - SUCCESS SECTION (CODE 1)
        else {
          app.errMsgUrl = ''; 
          app.loader = false;
          app.btnText = false;            
          app.shortURL = response.data.url; 
          app.form = false;              
          app.after = true;              
        }

      })
        .catch(function (error) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        });
    },


    //PREAPARE FORMDATA OBJECT  
    toFormData: function (obj) {
      let formData = new FormData();
      for (let key in obj) {
        formData.append(key, obj[key]);
      }
      return formData;
    }
  }
})

