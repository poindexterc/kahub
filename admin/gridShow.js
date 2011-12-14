$myjquery("#flex1").flexigrid({
	url: 'memberInfoRSS.php',
	dataType: 'xml',
	colModel : [
		{display: 'ID', name : 'id', width : 40, sortable : true, align: 'left'},
		{display: 'Name', name : 'name', width : 40, sortable : true, align: 'left'},
		{display: 'Friends', name : 'friends', width : 180, sortable : true, align: 'left'},
		{display: 'Comments', name : 'noComments', width : 120, sortable : true, align: 'left'},
		{display: 'SpamScore', name : 'spamScore', width : 130, sortable : true, align: 'left'},
		{display: 'Banned', name : 'banned', width : 80, sortable : true, align: 'right'}
		],
	searchitems : [
		{display: 'Name', name : 'name'},
		{display: 'spamScore', name : 'spamScore', isdefault: true},
		{display: 'Banned', name : 'banned'}
		],
	sortname: "id",
	sortorder: "asc",
	usepager: true,
	title: 'Countries',
	useRp: true,
	rp: 15,
	showTableToggleBtn: true,
	width: 700,
	height: 200
});
