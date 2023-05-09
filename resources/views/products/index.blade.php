@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control" value="{{request('title') ?? ''}}">
                </div>
                <div class="col-md-4">
                    <select name="variants[]" id="" class="form-control" multiple>
                        @php $group_labels = ["1" => 'Color', "2" => 'Size', "6" => 'Style']; @endphp
                        @php $query_variants = request('variants') ?? []; @endphp
                        @foreach ($variants as $key => $variant_groups)
                            
                            <optgroup label="{{ $group_labels[ $key ]  }}">
                                @foreach ($variant_groups as $variant)
                                    <option {{ in_array($variant->id, $query_variants) ? 'selected' : '' }} value="{{ $variant->id }}">{{ $variant->title }}</option>
                                @endforeach

                            </optgroup>

                        @endforeach
                        
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control" value="{{ request('price_from') ?? '' }}">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control" value="{{ request('price_to') ?? '' }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control" value="{{request('date') ?? ''}}">
                </div>
                <div class="col-md-1">
                    <a href="{{ route('product.index') }}" class="btn btn-danger float-right"><i class="fas fa-sync"></i></a>
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    
                    @foreach ($products as $key => $product)
                    
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $product->title ?? "" }} <br> Created at : {{ date('d-M-Y', strtotime($product->created_at)) }}</td>
                        <td>{{ $product->description ?? "" }}</td>
                        <td>
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">
                                
                                @foreach ($product->product_variant_prices as $variant_price)
                                    @if(request('price_from') !== null || request('price_to') !== null )
                                        @if($variant_price->price >= request('price_from') && $variant_price->price <= request('price_to'))
                                        <dt class="col-sm-3 pb-0">
                                            @if($variant_price->product_variant_one_title)
                                                {{ $variant_price->product_variant_one_title->title ?? "" }} /
                                            @endif
                                            @if($variant_price->product_variant_two_title)
                                                {{ $variant_price->product_variant_two_title->title ?? "" }} /
                                            @endif
                                            @if($variant_price->product_variant_three_title)
                                                {{ $variant_price->product_variant_three_title->title ?? "" }}
                                            @endif
                                        </dt>
                                        <dd class="col-sm-9">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4 pb-0">Price : {{ number_format($variant_price->price ?? 0 ,2) }}</dt>
                                                <dd class="col-sm-8 pb-0">InStock : {{ number_format($variant_price->stock ?? 0 ,2) }}</dd>
                                            </dl>
                                        </dd>
                                        @endif
                                        @else
                                        <dt class="col-sm-3 pb-0">
                                            @if($variant_price->product_variant_one_title)
                                                {{ $variant_price->product_variant_one_title->title ?? "" }} /
                                            @endif
                                            @if($variant_price->product_variant_two_title)
                                                {{ $variant_price->product_variant_two_title->title ?? "" }} /
                                            @endif
                                            @if($variant_price->product_variant_three_title)
                                                {{ $variant_price->product_variant_three_title->title ?? "" }}
                                            @endif
                                        </dt>
                                        <dd class="col-sm-9">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4 pb-0">Price : {{ number_format($variant_price->price ?? 0 ,2) }}</dt>
                                                <dd class="col-sm-8 pb-0">InStock : {{ number_format($variant_price->stock ?? 0 ,2) }}</dd>
                                            </dl>
                                        </dd>
                                    @endif
                                @endforeach
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                        
                    @endforeach

                    </tbody>

                </table>
            </div>
            <div class="text-center">
                {{ $products->links() }}
            </div>
        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} out of {{ $products->total() ?? 0 }}</p>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    </div>

@endsection
