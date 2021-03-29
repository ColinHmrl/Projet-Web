$(".role").change(function(){
    setPromo();
});
window.onload = function(){
    setPromo();
    $("#ph_under").css("display", "block")
    $("#ph_under").css("opacity", "40%")
    $(".sndPassword").css("display", "none")
};

$("#password").on('input',function(){
    console.log($(".sndPassword"))
    if($('#password').val() == ""){
        $("#ph_under").css("display", "block")
        $("#ph_under").css("opacity", "40%")
        $(".sndPassword").css("display", "none")
    }else{
        $("#ph_under").css("display", "none")
        $(".sndPassword").css("display", "block")
    }
});

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