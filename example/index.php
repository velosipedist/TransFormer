<?
error_reporting(E_ALL);ini_set('display_errors',1);
require __DIR__ . "/../src/init.php";
$manager = \TransFormer\TransFormer::instance(
	__DIR__ . '/forms',
	__DIR__ . '/tpl',
	'/_transformer'
);

?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Former + Parsley example</title>
	<link rel="stylesheet" type="text/css"
	      href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"/>
	<style type="text/css">
		.parsley-errors-list {
			display: none;
		}
	</style>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//parsleyjs.org/dist/parsley.min.js"></script>
</head>
<body>
<div class="navbar">
	<div class="container"><a class="navbar-brand" href="/">Example</a></div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<?
			\TransFormer\TransFormer::render('contact-simple');
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
	window.ParsleyConfig = {
		successClass: 'has-success',
		errorClass: 'has-error',
		classHandler: function (_el) {
			return _el.$element.closest('.form-group');
		},
		errors: {
			classHandler: function (el) {
				return el.parent();
			},
			// Set these to empty to make sure the default Parsley elements are not rendered
			errorsWrapper: '',
			errorElem: ''
		}
	};
	$.listen('parsley:field:error', function (parsleyField) {
		parsleyField.$element.tooltip({
			animation: false,
			container: 'body',
			placement: 'top',
			title: parsleyField.options.errorMessage
		});
	});
	$.listen('parsley:field:success', function (parsleyField) {
		$(this).tooltip('destroy');
	});

	$(function () {
		$('#MyForm').parsley();
	});
</script>
</body>
</html>