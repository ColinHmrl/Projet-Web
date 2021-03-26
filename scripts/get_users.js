$(document).ready( function () {
    console.log("jaj");
    $.ajax({
        url: "http://monprojet.fr/API/get_users/",
        type: "GET",
        //data: { name: "your_name", job: "what_you_want", place: "where_you_want" },
        dataType:"json", 
        success: function (response, textStatus, xhr) {
            var html = '';
            if (xhr.status == 200) {

                //html += JSON.stringify(response) +"</br>";
                
                $.each(response, function(firstIndex, firstElement) {

                    //html+="<p>element at " + index + ": " + el + "</p>";

                    if(firstIndex=="users") {
                        $.each(firstElement, function(indexUser, elementUser) {
                            html+="<tr>";
                            
                            
                                html+="<td>"+elementUser.first_name+"</td>";
                                html+="<td>"+elementUser.last_name+"</td>";
                                html+="<td>"+elementUser.roles+"</td>";
                            
                            html+="</tr>";
                        });
                    }
                });
                
            }
            else {
            }
            $('#user_result').html(html);
            $('#table_user').DataTable();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#user_result').html('Error: ' + xhr.status); console.log(thrownError);
        }
    });

    

});

    
