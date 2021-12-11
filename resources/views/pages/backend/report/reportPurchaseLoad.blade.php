<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Faktur</th>
            <th>Diskon</th>
            <th>Total</th>
        </tr>
    </thead>
    @foreach($data as $key => $value)
    <tbody class="dropHere" style="border: none !important">
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $value->date }}</td>
            <td>{{ $value->code }}</td>
            <td>{{ $value->discount }}</td>
            <td>{{ $value->price }}</td>
        </tr>
    </tbody>
    @endforeach
</table>