<style>
    .morectnt span {
        display: none;
    }
</style>

<?php
foreach($post as $p) {

    ?>
    <div class="onepost" id="post_<?php echo $p->post_id; ?>" >
    <hr class="noscreen" />
    <div class="article" >

        <h2>
                    <div class="title" id="title_<?php echo $p->post_id; ?>" style="text-align: center" contenteditable="false">
                <?php echo $p->title; ?>
                    </div>
        </h2>
        <p class="info noprint"><span class="date"><?php echo $p->post_time; ?></span><span class="noscreen">,</span>
            <span class="cat"><a href="#" class="editable" id="<?php echo $p->post_id; ?>" class="editable">Editable</a></span>
            <span class="noscreen">,</span> <span class="user"><a
                    href="#"><?php
                    switch ($p->private){
                        case 0:echo("public");break;
                        case 1:echo("private");break;
                        case 2:echo("friends");break;
                    }
                    ?></a></span><span class="noscreen">,</span> <span id="<?php echo $p->post_id; ?>" class="delete_post_lnk"><a href="#">Delete</a></span>
        </p>
        <div class="show" id="show_<?php echo $p->post_id; ?>" contenteditable="false">
            <?php echo $p->content; ?>
        </div>
        </p>

<!--        <p class="btn-more box noprint"><strong><a href="#">Continue</a></strong></p>-->
    </div>
    <hr class="noscreen"/>
    </div>
    <?php
}?>

<script type="text/javascript">
    $(document).ready(function() {
        //##### Send delete Ajax request to response.php #########
        $(".delete_post_lnk").click(function(e) {
            e.preventDefault();
            var postid = $(this).attr('id');

            //$('#post_'+postid).hide(); //change background of this element by adding class


            jQuery.ajax({
                type: "POST", // HTTP method POST or GET
                url: "<?php echo base_url() ?>index.php/page/delete_post", //Where to make Ajax calls
                dataType:"text", // Data type, HTML, json etc.
                data:{post_id:$(this).attr('id')}, //Form variables
                success:function(response){
                    //on success, hide  element user wants to delete.
                    $('#post_'+postid).fadeOut();
                },
                error:function (xhr, ajaxOptions, thrownError){
                    //On error, we alert user
                    alert(thrownError);
                }
            });
        });
        $(".editable").click(function (e) {
            $(this).attr("class","save");
            $(this).text("Save");
            var id=$(this).attr('id');
            $('#title_'+id).attr("contenteditable","true");
            $('#show_'+id).attr("contenteditable","true");
            CKEDITOR.disableAutoInline = true;
            $( '#title_'+id).ckeditor();
            $( '#show_'+id).ckeditor();
        })
    });
</script>



<script>
    $(function() {
        var showTotalChar = 200, showChar = "Show (+)", hideChar = "Hide (-)";
        $('.show').each(function() {
            var content = $(this).text();
            if (content.length > showTotalChar) {
                var con = content.substr(0, showTotalChar);
                var hcon = content.substr(showTotalChar, content.length - showTotalChar);
                var txt= con +  '<span class="dots">...</span><span class="morectnt"><span>' + hcon + '</span>&nbsp;&nbsp;<a href="" class="showmoretxt">' + showChar + '</a></span>';
                $(this).html(txt);
            }
        });
        $(".showmoretxt").click(function() {
            if ($(this).hasClass("sample")) {
                $(this).removeClass("sample");
                $(this).text(showChar);
            } else {
                $(this).addClass("sample");
                $(this).text(hideChar);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>
