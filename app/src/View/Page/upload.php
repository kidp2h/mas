<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/attendee.css">
<link rel="stylesheet" href="/resources/css/upload.css">
<?php $this->endStyle(); ?>

<?php $this->section('header'); ?>
<div id="header">
  <a href="/attendee/toppage">
    <img src="/resources/images/chevron-left.png">
  </a>
  <div class="wrapTitlePage">
    <img src="/resources/images/white-cam.png" alt="" srcset="">
    <span id="titlePage"><?= $titlePage ?></span>
  </div>


</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>

<div class="wrapFlex">
  <form id="content" method="post" enctype="multipart/form-data">
    <div class="groupInput">
      <span class="messageValidate" message="imgFile">Message</span>
      <input name="img" type="file" class="inputFileHidden" id="imgFile" accept=".jpg,.jpeg,.png">
      <input type="text" value="写真を選択して下さい select photo" readonly class="inputFileUpload">



    </div>


    <div class="image">
      <img src="" alt="" id="preview" onerror="this.style.display='none'">
      <span>選択した写真</span>
      <span>Selected Photo</span>
    </div>
    <div class="groupInput">
      <span class="messageValidate" message="message">Message</span>
      <textarea name="messsage" rows="10" cols="30" class="message" placeholder="メッセージをお願いします"></textarea>
    </div>

    <div class="groupInput">
      <span class="messageValidate" message="nickname">Message</span>
      <input type="text" class="nickname" placeholder="名前(ニックネーム)をお願いします">
    </div>

    <button class="upload" id="upload" type="submit">投　稿</button>
  </form>

</div>
<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  let validFile = false;
  let messageValidateFile = "";
  $(".inputFileUpload").addEventListener("click", function() {
    const img = $("#imgFile");
    img.click();

  })
  $("#upload").addEventListener("click", async function(e) {
    e.preventDefault();

    const rules = [{
      selector: "#imgFile",
      required: true
    }, {
      selector: ".message",
      required: true
    }, {
      selector: ".nickname",
      required: true
    }]

    const result = validator(rules);
    if (result === true) {
      const img = $("#imgFile");
      const message = $(".message").value;
      const nickname = $(".nickname").value;

      let form = new FormData();
      form.append("image", img.files[0]);
      form.append("message", message);
      form.append("nickname", nickname);
      const result = await fetch("/attendee/upload", {
        method: "POST",
        body: form,
      })
      if (result.status === 200) {
        const response = await result.json();
        console.log(response);
        $("#preview").src = '#';
        $(".inputFileUpload").value = "写真を選択して下さい select photo"
        $(".inputFileHidden").value = ""
      } else {
        console.log("error");
      }

    }
  })
  $("#imgFile").addEventListener("change", function() {
    const [file] = this.files
    console.log(file);
    const preview = $("#preview")
    const validSize = 3000000
    if (file) {
      if (!(/(.*?).png|jpg|jpeg/g.test(file.name))) {
        messageValidateFile = "File is not valid, please upload only image file"
        $(`#imgFile`).previousElementSibling.innerText = messageValidateFile
        $(`#imgFile`)?.previousElementSibling?.classList.add("active")
        $(`#imgFile`).classList.add("error")
      } else if (file.size > validSize) {
        console.log("size");
        messageValidateFile = "File too large, upload image file less than 3MB"
        $(`#imgFile`).previousElementSibling.innerText = messageValidateFile
        $(`#imgFile`)?.previousElementSibling?.classList.add("active")
        $(`#imgFile`).classList.add("error")
      } else {
        preview.src = URL.createObjectURL(file)
        $(".inputFileUpload").value = file.name
        $("#preview").style.display = "block";
        $("#imgFile").classList.remove("error")
        $(`#imgFile`)?.previousElementSibling?.classList.remove("active")
      }
    }
  })
</script>
<?php $this->endScript(); ?>;