/**
 * Created by yamilelias on 16/11/17.
 */

function openSearch() {
    var ob = $("#woocommerce-product-search-field-0");
    console.log("CSS: " + JSON.stringify(ob));
}
$(document).ready(function(){
    // for search bar
    $(".search-icon").click(function(){
        $(".search-form").slideToggle();
        $(".search-icon i.fa").toggleClass("fa-times fa-search");
    });
});