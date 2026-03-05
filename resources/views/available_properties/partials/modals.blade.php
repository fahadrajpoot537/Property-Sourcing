<!-- Offer Modal -->
<div class="modal fade" id="offerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-blue">Make an Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4" id="offerModalTitle"></p>
                <form action="{{ route('property.offer.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="property_id" id="offerPropertyId">
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Your Offer Amount (£)</label>
                        <div class="input-group offer-input-group">
                            <span class="input-group-text bg-light border-end-0 px-3 fw-bold">£</span>
                            <input type="number" name="offer_amount" class="form-control border-start-0 py-3"
                                step="0.01" required placeholder="e.g. 250000">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3"
                            placeholder="Any strict conditions or comments..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-custom-pink w-100 py-3 fw-bold text-uppercase">Submit
                        Offer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-blue">Message Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4" id="messageModalTitle"></p>
                <form action="{{ route('property.message.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="property_id" id="messagePropertyId">
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Your Message</label>
                        <textarea name="message" class="form-control" rows="5" required
                            placeholder="I'm interested in this property. Can you provide more details?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-blue w-100 py-3 fw-bold text-white text-uppercase">Send
                        Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .offer-input-group .input-group-text,
    .offer-input-group .form-control {
        height: 55px !important;
    }

    .btn-custom-pink {
        background-color: #F95CA8;
        color: white;
    }

    .btn-custom-pink:hover {
        background-color: #e04a92;
        color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const offerModal = document.getElementById('offerModal');
        if (offerModal) {
            offerModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const propertyId = button.getAttribute('data-property-id');
                const propertyTitle = button.getAttribute('data-property-title');
                document.getElementById('offerPropertyId').value = propertyId;
                document.getElementById('offerModalTitle').textContent = 'Property: ' + propertyTitle;
            });
        }

        const messageModal = document.getElementById('messageModal');
        if (messageModal) {
            messageModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const propertyId = button.getAttribute('data-property-id');
                const propertyTitle = button.getAttribute('data-property-title');
                document.getElementById('messagePropertyId').value = propertyId;
                document.getElementById('messageModalTitle').textContent = 'Property: ' + propertyTitle;
            });
        }
    });
</script>