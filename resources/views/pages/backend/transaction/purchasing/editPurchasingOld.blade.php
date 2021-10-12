					<tbody>
                        @php $i = 0 @endphp
                        @foreach($models as $row)
                        <tr class="dataDetail dataDetail_{{ $i }}">
                            <td style="display:none">
                                <input type="hidden" class="form-control priceDetailSparePart priceDetailSparePart_" name="idDetail[]" value="{{ $i }}">
                            </td>
                            <td>
                            <select class="select2 branchesDetail" name="branchesDetail[]">
                                <option value="-" data-index="">- Select -</option>
                                @foreach($branch as $rows)
                                    @if($row->branch_id == $rows->id)
                                    <option value="{{ $rows->id }}" selected>{{ $rows->name }}</option>
                                    @else
                                    <option value="{{ $rows->id }}">{{ $rows->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            </td>
                            <td>
                                <input type="text" class="form-control cleaveNumeral priceDetail priceDetail_" name="priceDetail[]" data-index="" value="{{ $row->price }}" style="text-align: right">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_'+(index+1)+'" name="totalPriceDetail[]" value="0" style="text-align: right">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger removeDataDetail" value="{{ $i }}" >X</button>
                            </td>
                        </tr> 
                        <tr class="dataDetail_{{ $i }}">
                            <td>
                            <select class="select2 itemsDetail" name="itemsDetail[]">
                                <option value="-" data-index="">- Select -</option>
                                @foreach($item as $rows)
                                    @if($row->item_id == $rows->id)
                                    <option value="{{ $rows->id }}" selected>{{ $rows->name }}</option>
                                    @else
                                    <option value="{{ $rows->id }}">{{ $rows->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            </td>
                            <td>
                                <input type="text" class="form-control qtyDetail qtyDetail_" name="qtyDetail[]" data-index="" value="{{ $row->qty }}" style="text-align: right;">
                            </td>
                            <!-- <td>
                                <input readonly type="text" class="form-control totalPriceDetail totalPriceDetail_" name="totalPriceDetail[]" value="0" style="text-align: right">
                            </td> -->
                        </tr> 
                        <tr class="dataDetail_{{ $i }}" style="border-bottom: solid 2px #ddd; margin-bottom: 5px;">
                            <td colspan="4">
                                <input type="text" class="form-control desDetail desDetail_" name="desDetail[]" placeholder="Deskripsi">
                            </td>
                        </tr> 
                        <tr class="dataDetail_{{ $i }}" height="50px">
                        </tr>
                        @php $i++ @endphp
                        @endforeach
                    </tbody>