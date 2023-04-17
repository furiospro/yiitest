$('.custom-class').on('click', () => {
	const fd = new FormData($('#login-form')[0]);
	const _csrf = fd.get('_csrf');
	const username = fd.get('LoginForm[username]');
	const password = fd.get('LoginForm[password]');
	const rememberMe = fd.get('LoginForm[rememberMe]');

	$.post('/?r=site/signup&XDEBUG_SESSION_START=1', {
		_csrf,
		SignUpForm: {
			username,
			password,
			rememberMe,
		},
	}).done((res) => {
		const result = JSON.parse(res);
		$.each(result.errors, (key,item) => {
			switch(key){
				case 'username':
				case 'password':
					$(`#loginform-${key}`).next().css('display', 'block').text(item[0])
					break;
				default:
					$('#login-form .invalid-feedback').each(function() {
						$(this).css('display', 'none');
					})
					break;
			}
		})

	});
});
$('.finish_course').on('click', () => {
	const url = new URLSearchParams(document.location.href);
	$.post(
		'/?r=site/finishcourse&XDEBUG_SESSION_START=1',
		{
			CoursesHelper: {
				id: url.get('id'),
			},
		},
		'json'
	).done(res => {
		res = JSON.parse(res);
		if (!res) {
			alert('Какая-та ошибка на сервере');
		}
	});
});
$('.add_course').on('click', () => {
	const fd = new FormData($('#addcourse-form')[0]);
	const _csrf = fd.get('_csrf');
	const name = fd.get('CoursesHelper[name]');
	const url = fd.get('CoursesHelper[url]');
	const description = fd.get('CoursesHelper[description]');

	$.post(
		'/?r=site/addcourse&XDEBUG_SESSION_START=1',
		{
			_csrf,
			CoursesHelper: {
				name,
				url,
				description,
			},
		},
		'json'
	).done(res => {
		res = JSON.parse(res);
		if (!res.res) {
			alert('Error');
		}
	});
});
