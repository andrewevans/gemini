<script id="pageTmpl" type="text/x-jquery-tmpl">
    <div class="${theClass}" style="${theStyle}">
        <div class="front">
            <div class="outer">
                <div class="content" style="${theContentStyleFront}">
                    <div class="inner">{{html theContentFront}}</div>
                </div>
            </div>
        </div>
        <div class="back">
            <div class="outer">
                <div class="content" style="${theContentStyleBack}">
                    <div class="inner">{{html theContentBack}}</div>
                </div>
            </div>
        </div>
    </div>
</script>
