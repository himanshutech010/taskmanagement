<div class="main-profile">
    <div class="profile-card-top">
        <div class="profile-card-left">
            <h3>{{ $client->client_name }}</h3>

            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Phone:</strong> {{ $client->mobile }}</p>
        </div>
        <div class="profile-card-right">
            @if ($client->linkedin)
                <a href="{{ $client->linkedin }}" target="_blank">
                    <i class="mdi  mdi-linkedin-box" style="font-size: 30px;"></i>
                </a>&nbsp
            @endif
            @if($client->skype)
                                            <a href="{{ $client->skype }}" target="_blank" >
                                            <i class="mdi mdi-skype-business" style="font-size: 30px;"></i> 
                                            </a>
                                      
                                        @endif
        </div>
    </div>
    <div class="profile-card-bottom">
    <p><strong>Project:</strong> 
        @foreach($client->projects as $project)
        <li><span style="font-size:18px; color:green;">{{ $project->name }} </span>-  <span class="badge {{ $project->status == 'Dev' ? 'badge-danger' :'badge-success'}}" style="font-size:14px;">
                                        {{ $project->status == 'Dev' ? 'DEV' : 'LIVE' }}
                                    </span></li>
    @endforeach
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
