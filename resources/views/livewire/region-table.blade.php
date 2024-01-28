
    <div>

        <div class="flex flex-col text-center">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full text-center bg-center divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        Original Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase">
                                        English Name
                                    </th>

                                    <!-- Add more header columns as needed -->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Example data -->


                                @foreach ($regions as $region)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $region->name }}</td>
                                        <td>{{ $region->name_en }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        {{ $regions->links() }} <!-- Renders the pagination links -->

        <div>
            Per Page:
            <select wire:model="perPage">
                <option>10</option>
                <option>20</option>
                <option>50</option>
            </select>
        </div>
    </div>
