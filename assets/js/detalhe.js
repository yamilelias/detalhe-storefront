/**
 * Created by yamilelias on 16/11/17.
 */

$(document).ready(function(){
    // for search bar
    $(".search-icon").click(function(){
        $(".search-form").slideToggle();
        $(".search-icon i.fa").toggleClass("fa-times fa-search");
    });
});