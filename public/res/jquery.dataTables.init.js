$(document).ready(function() {
	$('.datatable').DataTable( {
		"lengthMenu": [ [10, 25, -1], [10, 25, "All"] ],
		 "order": [[ 0, "asc" ]]
	} );
} );