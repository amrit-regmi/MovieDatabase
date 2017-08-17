

$(document).ready(function () {
    
    $("#addrow").on("click", function () {
        var row=$("table tr:first").clone().find("input").attr('value',"").end();
        row.show();
        var col = '<td><input type="button" class="ibtnDel"  value="Delete"></td>';  
        row.append(col); 
        row .appendTo("table");        
    });
    $(".order-list").on('click', ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
    });
  $(document).delegate(".mybutt1",'blur',(function(){
      
       var parentrow = $(this).parents('tr');
      parentrow.css('display','none');
      $(this).parents('tr').after('<tr/>').next().append('<td colspan=5"/>').children('td').append('<div/>').children().css('background','#f0f0f0','margin-top','30px','padding-top','20px').html($('#content').html());
  }));
    $(document).delegate(".mybutt",'click',function(){
    $(this).parents('tr').prev().show();
    $(this).parents('tr').remove();
    alert('hello');
    });
	
	 $('#delete').click(function(){
        $('#table input:checkbox').each(function(){
          
            if(this.checked){
                if(($('#table tr').length)<=2){alert('At least one artist is required');}else{
                    $(this).parents("tr").remove();}
            }
        });
        return false;
    });
});

function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	var colCount = table.rows[0].cells.length;
	for(var i=0; i<colCount; i++) {
		var newcell = row.insertCell(i);
		
		newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		}
}

function deleteRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chkbox = row.cells[0].childNodes[0];
		if(null != chkbox && true == chkbox.checked) {
			if(rowCount <= 1) { 						// limit the user from removing all the fields
				alert("At least one artist needs to be registered");
				break;
			}
			table.deleteRow(i);
			rowCount--;
			i--;
		}
	}
}
function addArtistDetail(tableID,rowId,inputId){
	var div = document.getElementbyID(rowID);
	var x=document
	
}*/

