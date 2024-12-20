<div class="main-profile">
   <div class="profile-card-top">
      <div class="profile-card-left">
         <h3>{{ $employee->name }}</h3>
         <p><strong>Username:</strong> {{ $employee->user_name }}</p>
         <p><strong>Email:</strong> {{ $employee->email }}</p>
         <p><strong>Role:</strong> {{ $employee->role }}</p>
         <p><strong>Gender:</strong> {{ $employee->gender }}</p>
      </div>
      <div class="profile-card-right">
         @if ($employee->image)
            <img src="{{ asset('public/admin/images/profile/' . $employee->image) }}" alt="{{ $employee->name }}" class="profile-image">
         @else
            @if ($employee->gender == 'Female')
               <img src="{{ asset('public/admin/images/profile/default1.png') }}" alt="default female image" class="profile-image">
            @else
               <img src="{{ asset('public/admin/images/profile/default.jpg') }}" alt="default male image" class="profile-image">
            @endif
         @endif
      </div>
   </div>
   <div class="profile-card-bottom">
    <p><strong>Date of Birth:</strong> {{ $employee->date_of_birth ? $employee->date_of_birth->format('d M Y') : 'N/A' }}</p>
      <p><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</p>
      <p><strong>Status:</strong>
         @if ($employee->status)
            <span class="badge badge-success">Active</span>
         @else
            <span class="badge badge-danger">Inactive</span>
         @endif
      </p>
      <p><strong>Online Status:</strong>
         @if ($employee->is_online)
            <span class="badge badge-success">Online</span>
         @else
            <span class="badge badge-danger">Offline</span>
         @endif
      </p>
      <p><strong>Departments:</strong>
         @forelse($employee->departments as $key => $department)
            <span>{{ $department->name }}</span>{{ $key < $employee->departments->count() - 1 ? ', ' : '' }}
         @empty
            <span style="color:red;">No departments assigned.</span>
         @endforelse
      </p>
      <p><strong>Description:</strong>
         {{ $employee->description ?? 'No description available.' }}
      </p>
   </div>
</div>

    <style>
        .profile-card-top {
            display: flex;
            justify-content: space-between;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

         .profile-card-bottom {
           
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-card-left {
            width: 65%;
        }

        .profile-card-right {
            width: 30%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-card-right img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .profile-card-top h3 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .profile-card-top p {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .badge-success {
            color: #fff;
            background-color: #28a745;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .badge-danger {
            color: #fff;
            background-color: #dc3545;
            padding: 3px 8px;
            border-radius: 5px;
        }

        .profile-image {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
