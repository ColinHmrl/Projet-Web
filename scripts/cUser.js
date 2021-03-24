$(".role").change(function(){
    if($( ".role" ).val() == "etudiant"){
        $('.promotion').html('<div class="field"><label for="selectPromotionLink">Promotion :</label><select class="form-select" id="selectPromotionLink"><option selected>Promotion</option>{% for promotion in promotions %}<option value={{strtolower(promotion) }}>{{promotion}}</option>{% endfor %}</select></div>');
    }else if($( ".role" ).val() == "Role"){
        $('.promotion').html("");
    }
    else{
        $('.promotion').html('<div class="field"><label>Promotion :</label> {% for promotion in promotions %} <div class="form-check"><input type="checkbox" class="form-check-input" id={{right.id}}><label class="form-check-label" for={{right.id}}>{{promotion.name}}</label></div>{% endfor %}</div>');
    }
});