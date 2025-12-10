<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .search-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .search-section form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-section input,
        .search-section select,
        .search-section button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .search-section button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }
        .search-section button:hover {
            background-color: #0056b3;
        }
        .add-product-section {
            margin-bottom: 30px;
            padding: 15px;
            background: #f0f8ff;
            border-left: 4px solid #007bff;
            border-radius: 5px;
        }
        .add-product-section h2 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
        }
        .add-product-section form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input,
        .form-group textarea {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .add-product-section button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            align-self: flex-start;
        }
        .add-product-section button:hover {
            background-color: #218838;
        }
        .alert {
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .errors {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .errors ul {
            margin: 0;
            padding-left: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #f5f5f5;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
            color: #333;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .pagination a {
            padding: 9px 13px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #666;
            user-select: none;
        }
        .pagination a[href] {
            color: #007bff;
        }
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Products</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @session('success')
            <div class="alert alert-success">
                {{ $value }}
            </div>
        @endsession

        <div class="add-product-section">
            <h2>Add New Product</h2>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description') }}</textarea>
                </div>
                <button type="submit">Add Product</button>
            </form>
        </div>

        <div class="search-section">
            <form action="{{ route('products.index') }}">
                <input type="text" name="q" placeholder="Search by title..." value="{{ $search }}">
                <input type="hidden" name="sort" value="{{ $sort }}">
                <button type="submit">Search</button>
                <a href="{{ route('products.index') }}" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #666;">Clear</a>
            </form>
        </div>

        @if ($products->count())
            <table id="products">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>
                            <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => $sort === 'desc' ? 'asc' : 'desc'])) }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 5px;">
                                Creation Date
                                <span style="font-size: 12px;">{{ $sort === 'desc' ? '↓' : '↑' }}</span>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><strong>{{ $product->title }}</strong></td>
                            <td>{{ $product->description ?? '-' }}</td>
                            <td>{{ $product->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($products->hasPages())
                <nav class="pagination">
                    <span>
                        <a @if(!$products->onFirstPage()) href="{{ $products->previousPageUrl() }}" @endif rel="prev">
                            &laquo; Previous
                        </a>
                    </span>
                    <span>Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
                    <span>
                        <a @if($products->hasMorePages()) href="{{ $products->nextPageUrl() }}" @endif rel="next">
                            Next &raquo;
                        </a>
                    </span>
                </nav>
            @endif
        @else
            <div class="empty-message">
                <p>No products found.</p>
            </div>
        @endif
    </div>
</body>
</html>
