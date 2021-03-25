$(document).ready(function() {
    $(".footer_total_mb").on('click',function(){
            var menuBox = document.getElementById('menu_home_mb');                
            if(menuBox.style.display == "block") { // if is menuBox displayed, hide it
                menuBox.style.display = "none";
            }
            else { // if is menuBox hidden, display it
                menuBox.style.display = "block";
            }
        });    
    $(".search_mobile").on('click',function(){
        var menuSearch = document.getElementById('search_form_mobile');  
        if(menuSearch.style.display == "block") { // if is menuBox displayed, hide it
            menuSearch.style.display = "none";
        }
        else { // if is menuBox hidden, display it
            menuSearch.style.display = "block";
        }
    });    
    $(".mobile_menu").simpleMobileMenu({
        onMenuLoad: function(menu) {
            
        },
        onMenuToggle: function(menu, opened) {
            
        },
        "menuStyle": "accordion"
    });
})