<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
  <title>OpenAI Assistant API Example</title>
</head>

<body class="p-4 md:px-10 bg-gray-100">
  <div class="mt-10 mx-auto w-full md:w-9/12 lg:w-5/12">
    <div class="">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">OpenAI Assistant API Example</h3>
        <p class="mt-1 text-sm text-gray-600">This is just an beta version, we are trying our best to make it better.</p>
      </div>
    </div>
    <div class="mt-5">
      <form action="" method="POST">
        <div class="overflow-hidden shadow sm:rounded-md">
          <div class="bg-white px-6 py-2">
            <div id="prompts-wrapper" class="h-[520px] overflow-y-auto">
              <p name="answer-text" class="w-3/4 mr-auto my-4 py-2 px-4 rounded-md text-sm bg-blue-500 text-white hidden"></p>
              <p name="question-text" class="w-3/4 ml-auto my-4 py-2 px-4 rounded-md text-sm bg-gray-400 text-white hidden"></p>
              <?php foreach (array_reverse($messages) as $message): ?>
                <?php if ($message['role'] == 'user'): ?>
                    <p name="question-text" class="w-3/4 ml-auto my-4 py-2 px-4 rounded-md text-sm bg-gray-400 text-white">
                      <?= nl2br($message['content'][0]['text']['value']) ?>
                    </p>
                <?php else: ?>
                    <p name="answer-text" class="w-3/4 mr-auto my-4 py-2 px-4 rounded-md text-sm bg-blue-500 text-white">
                      <?= nl2br($message['content'][0]['text']['value']) ?>
                    </p>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="bg-gray-50 text-right px-6 flex flex-wrap">
            <input tabindex="0" type="text" name="msg" id="first-name" placeholder="Ask a question" autocomplete="off" class="grow mr-6 my-4 block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            <button id="submit-btn" type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 py-2 px-4 my-4 text-sm font-medium text-white shadow-sm disabled:bg-gray-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              <svg class="animate-spin mr-2 hidden" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25" />
                <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" class="spinner_ajPY text-white" /></svg>
              <p>Send</p>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script>
  window.addEventListener("load", () => {
    document.getElementById("first-name").focus();

    document.getElementById("prompts-wrapper").lastElementChild.scrollIntoView({ behavior: "smooth" });
  });

  document.querySelector("form").addEventListener("submit", async (event) => {
    event.preventDefault();

    const submitBtn = document.getElementById("submit-btn");
    const question = event.srcElement[0].value;

    const p = document.querySelector("[name=question-text]").cloneNode();
    p.classList.remove("hidden");
    p.innerText = question;
    document.getElementById("prompts-wrapper").appendChild(p);
    p.scrollIntoView({ behavior: "smooth" });

    submitBtn.setAttribute("disabled", "");
    submitBtn.children[0].classList.remove("hidden");
    submitBtn.children[1].textContent = "processing";
    event.srcElement[0].value = "";

    const res = await fetch("/handle_request.php?userInput=" + question);

    if (res.status === 500) {
      window.alert("Sorry for the inconvenience, an error occurred.");
    }

    if (res.status === 200) {
      try {
        const answer = await res.text();

        if (answer) {
          const p = document.querySelector("[name=answer-text]").cloneNode();
          p.classList.remove("hidden");
          p.innerText = answer;
          document.getElementById("prompts-wrapper").appendChild(p);
          p.scrollIntoView({ behavior: "smooth" });
        }
      } catch (err) {
        window.alert("Sorry for the inconvenience, unexpected response.");
      }
    }

    submitBtn.removeAttribute("disabled");
    submitBtn.children[0].classList.add("hidden");
    submitBtn.children[1].textContent = "Send";
  });
  </script>
</body>

</html>