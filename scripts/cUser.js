$(".role").change(function(){
    setPromo();
});
window.onload = function(){
    setPromo();
};

function setPromo(){
    if($(".role").val() == "student"){
        $(".student").css("display", "block");
        $(".otherRole").css("display", "none");
        $(".rights").css("display", "none");
    }else if($(".role").val() == "pilot"){
        $(".student").css("display", "none");
        $(".otherRole").css("display", "block");
        $(".rights").css("display", "none");
    }else if($(".role").val() == "delegate"){
        $(".student").css("display", "none");
        $(".otherRole").css("display", "block");
        $(".rights").css("display", "block");
    }else{
        $(".student").css("display", "none");
        $(".otherRole").css("display", "none");
        $(".rights").css("display", "none");
    }
}