<div class="main-profile">
    <div class="profile-card-top">
        <div class="profile-card-left">
            <h3>{{ $project->name }}</h3>
            <p><strong>Client:</strong> {{ $project->client->client_name }} </p>
            <p><strong>Start Date:</strong> {{ $project->date ? $project->date->format('d M Y') : 'N/A' }} </p>

        </div>
        <div class="profile-card-right">
            <span class="badge {{ $project->status == 'Dev' ? 'badge-danger' : 'badge-success' }} fade-in-out"
                style="font-size:25px;">
                {{ $project->status == 'Dev' ? 'DEV' : 'LIVE' }}
            </span>
        </div>
    </div>
    <div class="profile-card-bottom">
        <h4>Assigned Developer & Technology</h4>
        <div class="assignment-grid">
            @foreach ($project->assignments as $assignment)
                <div class="assignment-card">
                    <div class="assignment-info">
                        <span class="employee-name">{{ $assignment->employee->name ?? 'N/A' }}</span>
                        <span class="department-name">({{ $assignment->department->name ?? 'N/A' }})</span>
                    </div>
                    @if ($assignment->is_moderator)
                        <span class="role-badge">Moderator</span>
                    @endif
                     @if ($assignment->employee->status== 0)
                        <span class="role-inactive">Currently Inactive</span>
                    @endif
                </div>
            @endforeach
        </div>
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
        background-color: #8f1111;
        padding: 3px 8px;
        border-radius: 5px;
    }

    .profile-image {
        border-radius: 50%;
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
    .profile-card-bottom {
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
}

.assignment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.assignment-card {
    background: white;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.assignment-card:hover {
    transform: scale(1.05);
}

.assignment-info {
    font-size: 16px;
    font-weight: 600;
}

.employee-name {
    color: #333;
}

.department-name {
    color: #555;
    font-size: 14px;
}

.role-badge {
    margin-top: 5px;
    display: inline-block;
    background: #1a387d;
    color: white;
    padding: 3px 8px;
    font-size: 12px;
    border-radius: 5px;
   
}

.role-inactive {
    margin-top: 5px;
    display: inline-block;
    background: #8f1111;
    color: white;
    padding: 3px 8px;
    font-size: 12px;
    border-radius: 5px;

}
</style>
