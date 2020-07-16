@extends('welcome')

@section('content')
<v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">Name</th>
          <th class="text-left">Calories</th>
        </tr>
      </thead>
      <tbody>
      	@for ($i = 0; $i < 10; $i++)
	        <tr>
	          <td>{{ $i }}</td>
	          <td>{{ $i++ }}</td>
	        </tr>
      	@endfor
      </tbody>
    </template>
  </v-simple-table>
@stop