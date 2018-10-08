@extends('layouts.app')

@section('title', 'Proxy list')
@section('h1', 'Proxy list')

@section('content')
    <div class="container meme_choose-template">
        <div class="row">
            <form action="{{route('proxies.index')}}" method="get" class="w-100">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="country">Country</label>
                        <select name="country" id="country" class="form-control">
                            <option value="">Select country</option>
                            @foreach($countries as $country)
                                <option value="{{$country->country}}"
                                        @if(request('country') === $country->country) selected @endif>
                                    {{$country->country}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="anonymity">Anonymity</label>
                        <select name="anonymity" id="anonymity" class="form-control">
                            <option value="">Select anonymity</option>
                            @foreach($anonymous as $anonymity)
                                <option value="{{$anonymity->anonymity}}"
                                        @if(request('anonymity') === $anonymity->anonymity) selected @endif>
                                    @switch($anonymity->anonymity)
                                        @case(\App\Proxy::ANONYMITY_ANONYMOUS)
                                        anonymous
                                        @break
                                        @case(\App\Proxy::ANONYMITY_NO)
                                        no
                                        @break
                                        @case(\App\Proxy::ANONYMITY_HEIGHT)
                                        height anonymous
                                        @break
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="available">Available</label>
                        <select name="available" id="available" class="form-control">
                            <option value="">Select available</option>
                            <option value="{{\App\CheckProxy::STATUS_OK}}"
                                    @if((int)request('available') === \App\CheckProxy::STATUS_OK) selected @endif>
                                Yes
                            </option>
                            <option value="{{\App\CheckProxy::STATUS_BAD}}"
                                    @if((int)request('available') === \App\CheckProxy::STATUS_BAD) selected @endif>
                                No
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Ip address</th>
                    <th scope="col">Port</th>
                    <th scope="col">Protocol</th>
                    <th scope="col">Country</th>
                    <th scope="col">Anonymity</th>
                    <th scope="col">Date check</th>
                    <th scope="col">Available</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proxies as $proxy)
                    <tr>
                        <td>{{$proxy->ip_address}}</td>
                        <td>{{$proxy->port}}</td>
                        <td>{{$proxy->protocol}}</td>
                        <td>{{$proxy->country}}</td>
                        <td>
                            @switch($proxy->anonymity)
                                @case(\App\Proxy::ANONYMITY_ANONYMOUS)
                                anonymous
                                @break
                                @case(\App\Proxy::ANONYMITY_NO)
                                no
                                @break
                                @case(\App\Proxy::ANONYMITY_HEIGHT)
                                height anonymous
                                @break
                            @endswitch
                        </td>
                        @if(null !== $proxy->checkProxy)
                            <td>{{$proxy->checkProxy->checked_at->format('d.m.Y H:i:s')}}</td>
                            <td>
                                @switch($proxy->checkProxy->status)
                                    @case(\App\CheckProxy::STATUS_OK)
                                    Yes
                                    @break
                                    @case(\App\CheckProxy::STATUS_BAD)
                                    No
                                    @break
                                @endswitch
                            </td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col">
                {{ $proxies->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection