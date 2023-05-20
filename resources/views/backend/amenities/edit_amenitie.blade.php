@extends('admin.admin_dashboard')
@section('admin')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

	<div class="page-content">

        <div class="row profile-body">
          <!-- left wrapper start -->


          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
              <div class="card">
              	<div class="card-body">

					<h6 class="card-title">Edit Amenitie</h6>

					<form method="post" action="{{ route('update.amenitie') }}" class="forms-sample">
						@csrf

            <input type="hidden" name="id" value="{{$amenities->id}}">
						<div class="mb-3">
							<label for="exampleInputUsername1" class="form-label">Amenitie Name</label>
							<input type="text" name="amenitie_name" class="form-control" value="{{ $amenities -> amenitie_name }}">
						</div>

						<button type="submit" class="btn btn-primary me-2">Save Changes</button>
					</form>

              	</div>
            </div>

            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->

          <!-- right wrapper end -->
        </div>

	</div>

@endsection