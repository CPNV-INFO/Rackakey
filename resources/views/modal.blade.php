<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title alert-danger">Suppression de clé usb</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Voulez-vous vraiment supprimer la clé contenant les informations suivantes:
                </p>
                <br/>
                <p>
                    Nom de la clé: <b id="deleteModalUsbName"></b>
                </p>
                <p>
                    Nombre de fois réservée: <b id="deleteModalReservationUsbCount"></b>
                </p>
                <p>
                    Espace disponible actuel: <b id="deleteModalUsbFreeSpace"></b>
                </p>
                <p>
                    Créée (insérée pour la toute première fois dans le hub, soit en mode "non initialisée"):<br/>
                    <b id="deleteModalUsbCreatedAt"></b>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="modalDeleteButton">Supprimer</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" od="modalCloseButton">Close
                </button>
            </div>
        </div>
    </div>
</div>