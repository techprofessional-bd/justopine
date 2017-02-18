
<header class="container-fluid col-md-12 col-xs-12">
				<div class="container-fluid">
				<div class="header-left">
					<img class="nav-logo" src="http://justopine.herokuapp.com/static/public/images/logo2.png">
				</div>
				<div class="header-right">
					<label for="open">
						<span class="hidden-desktop"></span>
					</label>
					<input type="checkbox" name="" id="open">
					<nav class="nav-component-div">
						@if(Session::get('logged')[0]['type']!="ADMIN")
						<a href="{!! url('/home') !!}">Dashboard</a>
						@endif
                        @if(Session::get('logged')[0]['type']=="TEACHER")
						<a href="{!! url('/teacher/'.Session::get('logged')[0]['user'].'/class/list') !!}">Class Lists</a>
						<a href="{!! url('/teacher/assignment/new') !!}">Set Assignment</a>
                        @endif
						@if(Session::get('logged')[0]['type']=="ADMIN")
							<a href="{!! url('/admin/dashboard') !!}">Dashboard</a>
							<a href="{!! url('/admin/class') !!}">Class</a>
							<a href="{!! url('/admin/pupil') !!}">Pupils</a>
							<a href="{!! url('/admin/teachers') !!}">Teachers</a>
							{{--<a href="{!! url('/admin/subjects') !!}">Subjects</a>--}}
							<a href="{!! url('/admin/categories') !!}">Category</a>
						@endif
                        @if(Session::get('logged')[0]['type']=="PUPIL")
                            <a href="{!! url('/student/feedback') !!}">Feedback</a>
                            @endif
						<a href="{!! url('/logout') !!}">Logout {{Session::get('logged')[0]['user']}}</a>

					</nav>
				</div>
			</div>
		</header>