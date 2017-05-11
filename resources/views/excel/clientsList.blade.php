<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Industry</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>BD Grade</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                     @foreach($clients As $index => $client)
                                    <tr>
                                        <td>{!! $index+1 !!}</td>
                                        <td>{!! $client->name !!}  </td>
                                        <td>{!! $client->industryName !!}</td>
                                        <td>{{  $client->countryName }} </td>
                                        <td>@if($client->city) {{ $client->cityName }} @else Multiple Cities @endif</td>
                                        <td>{{ $client->currentStatus }}</td>
                                        <td>{{ $client->bdGrade }}</td>
                                        <td>{{ $client->phone }} </td>
                                    </tr>
                                     
                                @endforeach
                                     
                                </tbody>
                            </table>