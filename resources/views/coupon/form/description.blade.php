<div class="col-lg-12 ">
    <div class="row">
        <div class="form-group col-lg-12">
            <div class="col-lg-3 control-label">
                <label for="{{ 'name['.$language.']' }}">
                    <span class="text-danger">*</span> {{ trans_append_language('Description',$lang) }}
                </label>
            </div>
            <div class="col-lg-6">
                <input
                    type="text"
                    class="form-control content-name"
                    name="{{ 'description['.$language.']' }}"
                    maxlength="255"
                    placeholder="No longer than 255 characters"
                    value='{{ isset($name)? $name : ''}}'>
            </div>
        </div>
    </div>
</div>