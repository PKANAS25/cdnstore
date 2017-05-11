<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Company</th> 
                                        <th>Industry</th> 
                                        <th>Position</th> 
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Mobile</th> 
                                        <th>Phone</th> 
                                        <th>Email</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                     @foreach($contacts As $index => $contact)
                                    <tr>
                                        <td>{!! $index+1 !!}</td> 
                                        <td>{!! $contact->name !!}</td>
                                        <td>{!! $contact->clientName !!}</td>
                                        <td>{{  $contact->industryName }} </td>
                                        <td>{{  $contact->positionName }} </td>
                                        <td>{{  $contact->countryName }} </td>
                                        <td>@if($contact->city) {{ $contact->cityName }} @else Multiple Cities @endif</td>
                                        <td>{{ $contact->mobile }}</td>
                                         <td>{{ $contact->phone }} @if($contact->phone2) , {{ $contact->phone2 }} @endif</td>
                                        <td>{{ $contact->email }}</td>
                                         
                                    </tr>
                                     
                                @endforeach
                                     
                                </tbody>
                            </table>