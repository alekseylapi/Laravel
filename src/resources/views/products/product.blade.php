@php /** @var App\Models\Product $product */ @endphp
<h1>{{ $product->name }}</h1>
<table>
    <tr>
        <td>Цена</td>
        <td>{{ $product->price }}</td>
    </tr>
    <tr>
        <td>Категория</td>
        <td>{{ $product->category->name }}</td>
    </tr>
</table>
