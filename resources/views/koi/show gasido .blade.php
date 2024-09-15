<h1>{{ $koi->name }}</h1>
<p>Dimiliki oleh: {{ $koi->auction->user->name }}</p>
<p>Auction ID: {{ $koi->auction->id }}</p>

<h2>Media</h2>
<ul>
    @foreach ($koi->media as $media)
        <li>{{ $media->url }}</li>
    @endforeach
</ul>

<h2>Certificates</h2>
<ul>
    @foreach ($koi->certificates as $certificate)
        <li>{{ $certificate->title }}</li>
    @endforeach
</ul>

<h2>Bids</h2>
<ul>
    @foreach ($koi->bids as $bid)
        <li>{{ $bid->amount }} by {{ $bid->user->name }}</li>
    @endforeach
</ul>

<h2>Marked Kois</h2>
<ul>
    @foreach ($koi->markedKois as $markedKoi)
        <li>{{ $markedKoi->user->name }} marked this koi</li>
    @endforeach
</ul>
