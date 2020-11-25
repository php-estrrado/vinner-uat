$(document).ready(function() {
    $('#example').DataTable({

		"bLengthChange": false,
		"iDisplayLength": 5,
		"ordering": false,
		"searching": true
       });
});


// function checkAll(bx) {
//   var cbs = document.getElementsByTagName('input');
//   for(var i=0; i < cbs.length; i++) {
//     if(cbs[i].type == 'checkbox') {
//       cbs[i].checked = bx.checked;
//     }
//   }
// }