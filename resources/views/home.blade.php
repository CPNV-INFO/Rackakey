@extends('layouts.app')

@section('content')
    <div>
        <h5 style="text-align: right; margin-right: 5%;">{{ $user }}</h5></div>
    <div>
        <br><h1 style="margin-left: 5%;">Gestion rack à clés USB</h1><br>
    </div>
    <div class="wrap-table100">
        <div class="table100 ver1 m-b-110">

            <!-- Table Header -->
            <div class="table100-head">
                <table>
                    <thead>
                    <tr class="row100 head">
                        <th class="cell100 column1">Numéro Clé</th>
                        <th class="cell100 column2">Etat</th>
                        <th class="cell100 column3">Port rack</th>
                        <th class="cell100 column4">Réservé par</th>
                        <th class="cell100 column5">Espace libre</th>
                        <th class="cell100 column6">Actions
                        <th class="cell100 column7"><a href="#" style="text-align: right;" onclick="loadUSBKey()"><img src="images/icons/add_usb.png" height="30px"></a></th>
                        <th class="cell100 column8"></th>
                    </tr>
                    </thead>
                </table>
            </div>

            <!-- All table lines -->

            @foreach ($usb as $actualUsb)
                <div class="table100-body js-pscroll">
                    <table>
                        <tbody>
                        <tr class="row100 body">
                            <td class="cell100 column1"> {{ $actualUsb->id }}</td>
                            <td class="cell100 column2">{{ $actualUsb->status->name }}</td>
                            <td class="cell100 column3">Rack 1 - Port 1</td>
                            <td class="cell100 column4">-</td>
                            <td class="cell100 column5"> {{ $actualUsb->freeKbyteSpace }}kb</td>
                            <td class="cell100 column6"><a href="#" onclick="delUSBKey()"><img src="images/icons/delete.png" height="40px"></a></td>
                            <td class="cell100 column7"><a href="#"><img src="images/icons/download.png" title="Télécharger toutes les données en local puis réinitialiser la clé USB" height="40px" style="margin-right:25px;" style="margin-right:25px;"></a></td>
                            <td class="cell100 column8"><a href="./encode_explorer/index.php?usbRack=1&usbKeyPort=1"><img src="images/icons/folder.png" title="Explorer" height="40px"></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach

            <a href="addreservation.html" class="flatbutton" name="addreservation">Créer une réservation</a>
        </div>
    </div>


    <!-- Notification -->
    <div class="toast__container" >
        <div class="toast__cell">
            <div class="toast toast--green" id="toast01">
                <div class="toast__icon">
                    <svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<g><g><path d="M504.502,75.496c-9.997-9.998-26.205-9.998-36.204,0L161.594,382.203L43.702,264.311c-9.997-9.998-26.205-9.997-36.204,0    c-9.998,9.997-9.998,26.205,0,36.203l135.994,135.992c9.994,9.997,26.214,9.99,36.204,0L504.502,111.7    C514.5,101.703,514.499,85.494,504.502,75.496z"></path>
                </g></g>
			</svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Succès</p>
                    <p class="toast__message">2 Clés USB ont été initialisées.</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="toast__cell">
            <div class="toast toast--green" id="toast02">
                <div class="toast__icon">
                    <svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
			<g><g><path d="M504.502,75.496c-9.997-9.998-26.205-9.998-36.204,0L161.594,382.203L43.702,264.311c-9.997-9.998-26.205-9.997-36.204,0    c-9.998,9.997-9.998,26.205,0,36.203l135.994,135.992c9.994,9.997,26.214,9.99,36.204,0L504.502,111.7    C514.5,101.703,514.499,85.494,504.502,75.496z"></path>
                </g></g>
			</svg>
                </div>
                <div class="toast__content">
                    <p class="toast__type">Succès</p>
                    <p class="toast__message">La clé USB N°1 a bien été supprimée.</p>
                </div>
                <div class="toast__close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <br><br>
@endsection
