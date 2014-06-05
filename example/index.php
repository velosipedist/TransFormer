<?
require __DIR__ . "/../main.php";
TransFormer::setup(array(
	TransFormer::FORMS_ROOT => __DIR__ . '/forms',
));
$rules = array(
	'name' => 'required|email',
	'bar' => 'required|min:2',
);
TransFormer::registerForm('contact-simple', $rules);
if (isset($_POST['name'])) {
	$data = array_intersect_key($_POST, array('name' => '', 'bar' => ''));
	if (!TransFormer::validate($data)) {
		print "<p>Data is valid. You can <a href='/'>go back</a>.";
	} else {
		var_dump(TransFormer::errors());
	}
}
?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Former + Parsley example</title>
	<link rel="stylesheet" type="text/css"
		  href="/css/bootstrap.min.css"/>
	<style type="text/css">
		.parsley-errors-list {
			display: none;
		}
	</style>
	<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/parsley.min.js"></script>
</head>
<body>
<div class="navbar">
	<div class="container"><a class="navbar-brand" href="/">Example</a></div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<?
			TransFormer::render('contact-simple');
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

</script>
</body>
</html>