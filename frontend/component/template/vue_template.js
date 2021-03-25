var app_footer = new Vue({
	el:'#crudFooter',
	data:{	
        logo_footer:'',
        footer_phone:'',
        footer_fb_url:'',
        footer_g_plus_url:'',
        footer_instagram_url:'',
        footer_youtube: '',
        fanpage: '',
        footer_copy_text: ''				 
	},
	methods:{
		fetchData:function(id){
            axios.post(URL + 'api/api_footer', {
                action:'fetchSingle'               
            }).then(function(response){   				 				
                app_footer.logo_footer  = response.data.logo;
                app_footer.footer_phone = response.data.phone;	
                app_footer.footer_fb_url = response.data.fb_url;	
                app_footer.footer_g_plus_url = response.data.g_plus_url;
                app_footer.footer_instagram_url = response.data.instagram_url;
                app_footer.footer_youtube = response.data.youtube;
                app_footer.fanpage = response.data.fanpage;
                app_footer.footer_copy_text = response.data.footer_copy_text;
            });	
        },				
	},
	created:function(){
		this.fetchData();			
	}
});
var app_header = new Vue({
	el:'#crudHeader',
	data:{	
        logo_header: ''    		 
	},
	methods:{
		fetchDataHeader:function(id){
            axios.post(URL + 'api/api_header', {
                action:'fetchFooter'               
            }).then(function(response){   				 				
                app_header.logo_header  = response.data.logo;                
            });	
        },			
	},
	created:function(){
		this.fetchDataHeader();			
	}
});