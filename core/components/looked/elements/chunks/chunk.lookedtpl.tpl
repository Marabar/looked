<div class="looked-ms2-product clearfix looked-[[+id]]">
    <button type="button" class="close looked-remove" data-id="[[+id]]" data-looked="looked/remove" title="[[%looked_remove_lokeed]]">x</button>
    <div class="col-xs-2 col-sm-2"><img src="[[+24x92]]" width="24" height="92" /></div>
    <div class="col-xs-10 col-sm-10">
        
        <form method="post" class="ms2_form">
            <h4 class="title-product"><a href="[[+uri]]"><strong>[[+pagetitle]]</strong></a></h4>
            <span class="price">
                <span class="price-int"><strong>[[+price]]</strong></span> <strong>[[%ms2_frontend_currency]]</strong>
            </span>
            <br />
            
            <button class="btn btn-default" type="submit" name="ms2_action" value="cart/add">[[%ms2_frontend_add_to_cart]]</button>

            <input type="hidden" name="id" value="[[+id]]">
            <input type="hidden" name="count" value="1">
            <input type="hidden" name="options" value="[]">
        </form>

    </div>
</div>
<br />
