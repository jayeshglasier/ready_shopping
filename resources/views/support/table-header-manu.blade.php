<div class="col-12 col-md-2 filter-forms" style="padding-right: 0px;padding-left: 10px;">
    <div class="form-group">
        <select class="form-control selectric" name="asc_desc_filter" required>
           <option value="DESC" @if($pageOrder == 'DESC') selected="true" @endif>Order by DESC</option>
            <option value="ASC" @if($pageOrder ==  'ASC') selected="true" @endif>Order by ASC</option>
        </select>
    </div>
</div>
<div class="col-12 col-md-2 filter-forms" style="max-width: 8.667% !important;padding-right: 0px;padding-left: 10px;">
    <div class="form-group">
        <select class="form-control selectric" name="pagefilter" required>
            <option value="10" @if($pages == 10) selected="true" @endif>10</option>
            <option value="20" @if($pages == 20) selected="true" @endif>20</option>
            <option value="30" @if($pages == 30) selected="true" @endif>30</option>
            <option value="40" @if($pages == 40) selected="true" @endif>40</option>
            <option value="50" @if($pages == 50) selected="true" @endif>50</option>
            <option value="100" @if($pages == 100) selected="true" @endif>100</option>
            <option value="150" @if($pages == 150) selected="true" @endif>150</option>
            <option value="200" @if($pages == 200) selected="true" @endif>200</option>
        </select>
    </div>
</div>
<div class="col-12 col-md-2 filter-forms" style="padding-right: 0px;padding-left: 10px;">
    <button class="btn btn-primary">Go</button>
</div>
                   