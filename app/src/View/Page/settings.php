<?php $this->layout('main'); ?>

<?php $this->style(); ?>
<link rel="stylesheet" href="/resources/css/settings.css">
<?php $this->endStyle(); ?>
<?php $this->section('header'); ?>
<span id="titlePage">
  <span class="textPC"><?= $titlePage ?></span>
  <span class="textMobile">Settings</span>
</span>
<div class="groupAction">
  <div class="btn-action" id="btn-register-event">
    <a href="#">登録</a>
  </div>
  <div class="btn-action">
    <a href="/"> 戻る</a>

  </div>

</div>
<?php $this->end(); ?>

<?php $this->section('content'); ?>
<div id="formSettings">

  <form method="post">
    <div class="groupInput">
      <label class="titleGroup">登録日</label>
      <div class="textValue">
        <span><?= $settings['created_at'] ?></span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup">ご利用状態</label>
      <div class="textValue">
        <span><?= $settings['useFlag'] ? "useFlag: 1" : "useFlag: 0" ?></span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup textPC">お名前（主催者名）</label>
      <label class="titleGroup textMobile">お名前</label>
      <div class="inputValue">

        <input type="text" id="fullname" value="<?= $settings['name'] ?? "" ?>">
        <span class="messageValidate" message="fullname">Message</span>
      </div>
    </div>

    <div class="groupInput">
      <label class="titleGroup">メールアドレス</label>
      <div class="inputValue">

        <input type="email" id="email" value="<?= $settings['email'] ?? "" ?>">
        <span class="messageValidate" message="email">Message</span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup">イベント名称</label>
      <div class="inputValue">

        <input type="text" id="eventTitle" value="<?= $settings['eventTitle'] ?? "思い出アルバム" ?>">
        <span class="messageValidate" message="eventTitle">Message</span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup textPC">出席者へのメッセージ</label>
      <label class="titleGroup textMobile">メッセージ</label>
      <div class="inputValue">
        <textarea id="welcomeMessage"><?= $settings['welcomeMessage'] ?? "写真をたくさん投稿してね!" ?></textarea>
        <span class="messageValidate" message="welcomeMessage">Message</span>
      </div>
    </div>
    <div class="groupInput">
      <label class="titleGroup">メッセージ画像</label>
      <div class="inputFile">

        <input name="img" type="file" class="inputFileHidden" id="imgFile" accept=".jpg,.jpeg,.png" value="<?= $settings['welcomeMessageFilename'] ?? "" ?>">
        <div class="groupInput">
          <input type="text" value="<?= $settings['welcomeMessageFilename']  ?? '写真を選択して下さい' ?>" readonly class="inputFileUpload" value="">
          <span class="messageValidate" message="inputFileUpload">Message</span>
        </div>
        <!-- <span class="messageValidate">Message</span> -->
        <div class="selectedImage">
          <div class="wrapText">
            <div>選択画像</div>
            <img id="preview" src="<?= $settings['welcomeMessageFilename'] ? "/resources/uploads/" . $settings['welcomeMessageFilename'] : "" ?>" alt="" onerror="this.style.display='none'">
          </div>

        </div>
      </div>
    </div>

    <div class="groupInput">
      <label class="titleGroup">スライドショーパターン</label>
      <div class="groupRadioWithPattern">
        <div class="radioPattern">
          <input type="radio" id="pattern1" name="pattern" value="1" <?= $settings['actionFlag'] === 1 ? "checked" : ""  ?>>
          <div class="pattern pattern1">
            <span>Pattern 1</span>
          </div>
        </div>
        <div class="radioPattern">
          <input type="radio" id="pattern2" name="pattern" value="2" <?= $settings['actionFlag'] === 2 ? "checked" : ""  ?>>
          <div class="pattern pattern2">
            <span>Pattern 2</span>
          </div>
        </div>

      </div>
    </div>

    <div class="groupInput groupInput1Line">
      <label class="titleGroup textPC">展示パネルQRコード表示</label>
      <label class="titleGroup textMobile"> QRコード表示</label>


      <div class="groupRadioWithText">
        <div class="radioText">
          <input type="radio" id="option1" name="qr" value="1" <?= $settings['QRCodeFlag'] ? "checked" : ""  ?>>
          <span>する</span>
        </div>
        <div class="radioText">

          <input type="radio" id="option2" name="qr" value="0" <?= $settings['QRCodeFlag'] ? "" : "checked"  ?>>
          <span class="textPC">しない（展示パネルにQRコードを表示しません）</span>
          <span class="textMobile">しない</span>
        </div>

  </form>
</div>





<?php $this->end(); ?>

<?php $this->startScript(); ?>
<script>
  let validFile = false;
  let messageValidateFile = "";
  let inputTextIsChanged = false;
  let imageIsChanged = false;
  $$('input[type="text"],input[type="email"], textarea').forEach(item => {
    item.onchange = function(e) {
      inputTextIsChanged = true;
    }
  })

  $$('input[type="file"]').forEach(item => {
    item.onchange = function(e) {
      imageIsChanged = true;
    }
  })
  $(".inputFileUpload").addEventListener("click", function() {
    const img = $("#imgFile");
    img.click();

  })
  $("#btn-register-event").addEventListener("click", async function(e) {
    e.preventDefault();
    const rules = [{
        selector: ".inputFileUpload",
        required: true
      }, {
        selector: "#fullname",
        require: true,
        min: 1,
        max: 255,
      }, {
        selector: "#eventTitle",
        require: true,
        min: 1,
        max: 255,
      },
      {
        selector: "#email",
        require: true,
        min: 1,
        max: 255,
      },
      {
        selector: "#welcomeMessage",
        require: true,
        min: 1,
        max: 255,
      }
    ]
    if (!imageIsChanged && !inputTextIsChanged) {
      window.location.href = '/';
    } else {
      const result = validator(rules);
      if (result === true) {
        const img = $("#imgFile");
        const fullname = $("#fullname").value;
        const eventTitle = $("#eventTitle").value;
        const email = $("#email").value;
        const welcomeMessage = $("#welcomeMessage").value;
        const QRCodeFlag = +$(`input[name='qr']:checked`).value
        const actionFlag = +$(`input[name='pattern']:checked`).value

        let form = new FormData();
        if (imageIsChanged) form.append("image", img.files[0]);

        form.append("fullname", fullname);
        form.append("eventTitle", eventTitle);
        form.append("email", email);
        form.append("welcomeMessage", welcomeMessage);
        form.append("QRCodeFlag", QRCodeFlag);
        form.append("actionFlag", actionFlag);
        const result = await fetch("/update-settings", {
          method: "POST",
          body: form,
        })
        const response = await result.json();
        if (result.status === 200) {
          if (response.status === true) {
            window.location.href = '/';
          }
        } else {

        }

      }
    }

  })
  $("#imgFile").addEventListener("change", function() {
    const [file] = this.files
    const preview = $("#preview")
    const validSize = 3000000
    const messageValidateSelector = $(`span[message='imgFile']`)
    if (file) {
      console.log(file);
      if (!(/(.*?).png|jpg|jpeg/g.test(file.name))) {
        console.log("ext");
        messageValidateFile = "File is not valid, please upload only image file"
        $(`span[message='imgFile']`).innerText = messageValidateFile
        $(`span[message='imgFile']`)?.classList.add("active")
        $(`#imgFile`).classList.add("error")
        validFile = false;
      } else if (file.size > validSize) {
        console.log("size");
        messageValidateFile = "File too large, upload image file less than 3MB"
        $(`span[message='imgFile']`).innerText = messageValidateFile
        $(`span[message='imgFile']`)?.classList.add("active")
        $(`#imgFile`).classList.add("error")
        validFile = false;
      } else {
        const bufferView = new Uint8Array(file)
        console.log(bufferView);
        const blob = new Blob([bufferView], {
          type: "image/jpeg"
        });
        console.log(blob);
        preview.src = URL.createObjectURL(file)
        $(".inputFileUpload").value = file.name
        $("#preview").style.display = "block";
        $("#imgFile")?.classList.remove("error")
        $(`span[message='imgFile']`)?.classList.remove("active")
        validFile = true;
      }
    }
  })
</script>
<?php $this->endScript(); ?>;