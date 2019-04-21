<div class="row">
    {foreach from=$statistics item=aItem}
    <div class="col-sm-6 col-md-3 col-lg-3">
        <div class="statistic-item">
            <div class="icon">
                <i class="fa fa-{$aItem.icon}"></i>
            </div>
            <div class="fact-count">
                <h4>{_p var=$aItem.title}</h4>
                <h3><span class="counter">{$aItem.count}</span></h3>
            </div>
        </div>
    </div>
    {/foreach}
</div>