var app_home = new Vue({
	el:'#app_home',
	data:{	
		tin_tuc_one: '' ,
		allNews:[] ,
		allNoibat: []  		 
	},
	methods:{
		fetchAllNoiBat:function(){            
            axios.post(URL+'api/api_noibat', {               
                action:'fetchAllNoiBat'
            }).then(function(response){
				app_home.allNoibat = response.data;								
            });
        },
		fetchAllNew2:function(){            
            axios.post(URL+'api/api_news2', {               
                action:'fetchNewPost2'
            }).then(function(response){
				app_home.allNews = response.data;				
            });
        },
		fetchDataNewPost:function(id){
            axios.post(URL + 'api/api_newspost', {
                action:'fetchNewPost'               
            }).then(function(response){   				 				
                app_home.tin_tuc_one  = response.data.tin_tuc_one;                
            });	
        },			
	},
	created:function(){		
		this.fetchDataNewPost();
		this.fetchAllNew2();
		this.fetchAllNoiBat();			
	}
	
});