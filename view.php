<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
  <title>OpenAI Assistant API Example</title>
</head>

<body class="p-4 md:px-10 bg-gray-100">
  <div class="mt-10 mx-auto w-full text-center md:w-9/12 lg:w-5/12">
    <div class="">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium leading-6 text-gray-900">OpenAI Assistant API Example</h3>
        <p class="mt-1 text-sm text-gray-600">This is just an beta version, we are trying our best to make it better.</p>
      </div>
    </div>
  </div>

  <div class="flex flex-col gap-12 lg:flex-row lg:w-full lg:justify-center">
    <div class="flow-root pt-16 px-4">
      <ul role="list" class="-mb-8 h-[420px]">

        <?php foreach ($threads as $thread): ?>
          <li>
            <div class="relative pb-8">
              <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
              <div class="relative flex space-x-3">
                <div>
                  <span class="h-10 w-10 rounded-full bg-gray-400 flex items-center justify-center">
                    <!-- Heroicon name: solid/Archive-Box -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 00-1.032-.211 50.89 50.89 0 00-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 002.433 3.984L7.28 21.53A.75.75 0 016 21v-4.03a48.527 48.527 0 01-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979z"></path>
                      <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 001.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0015.75 7.5z"></path>
                    </svg>
                  </span>
                </div>
                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                  <div>
                    <?php if ($requested_thread_id == $thread['assistant_id']): ?>
                      <p class="text-sm text-emerald-500"><a href="?thread_id=<?= $thread['assistant_id'] ?>" class="font-medium text-emerald-500"><?= $thread['assistant_id'] ?></a></p>
                    <?php else: ?>
                      <p class="text-sm text-gray-500"><a href="?thread_id=<?= $thread['assistant_id'] ?>" class="font-medium text-gray-900"><?= $thread['assistant_id'] ?></a></p>
                    <?php endif; ?>
                  </div>
                  <div class="text-right text-sm whitespace-nowrap text-gray-500">
                    <time datetime="2020-09-20"><?= $thread['timestamp'] ?></time>
                  </div>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>

        <button id="thread-btn" class="inline-flex justify-center rounded-md border border-transparent bg-blue-500 py-2 px-4 my-4 text-sm font-medium text-white shadow-sm disabled:bg-gray-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          <svg class="animate-spin mr-2 hidden" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25" />
          <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" class="spinner_ajPY text-white" /></svg>
          <p>Create a new Thread</p>
        </button>

      </ul>
    </div>

    <div class="mt-5 w-full lg:w-3/6">
      <form action="" method="POST">
        <div class="overflow-hidden shadow sm:rounded-md">
          <div class="bg-white px-6 py-2">
            <div id="prompts-wrapper" class="h-[420px] overflow-y-auto">
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

  document.getElementById("thread-btn").addEventListener("click", async (event) => {
    event.currentTarget.setAttribute("disabled", "");
    event.currentTarget.children[0].classList.remove("hidden");
    event.currentTarget.children[1].textContent = "creating...";
    const res = await fetch("/create_thread.php");

    if (res.status === 500) {
      window.alert("Sorry for the inconvenience, an error occurred.");
    } else if (res.status === 200) {
      location.replace("/");
    }
    event.currentTarget.removeAttribute("disabled");
    event.currentTarget.children[0].classList.add("hidden");
    event.currentTarget.children[1].textContent = "Create a new Thread";
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
    submitBtn.children[1].textContent = "processing...";
    event.srcElement[0].value = "";

    const res = await fetch("/handle_request.php?query=" + question + "&thread_id=<?= $requested_thread_id ?>");

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