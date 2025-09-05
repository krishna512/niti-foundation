// jQuery(function ($) {
//   const $audio = $('#audio');
//   const $playPauseBtn = $('#play-pause');
//   const $seekBar = $('#seek-bar');
//   const $volumeBar = $('#volume-bar');
//   const $currentTimeEl = $('#current-time');
//   const $durationEl = $('#duration');

//   // Play/Pause button functionality
//   $playPauseBtn.on('click', function () {
//     if ($audio[0].paused) {
//       $audio[0].play().catch(function (error) {
//         console.error('Error playing audio:', error);
//       });
//       $playPauseBtn.removeClass('play').addClass('pause');
//     } else {
//       $audio[0].pause();
//       $playPauseBtn.removeClass('pause').addClass('play');
//     }
//   });

//   // Update seek bar and time
//   $audio.on('timeupdate', function () {
//     var currentTime = Math.floor($audio[0].currentTime);
//     var duration = Math.floor($audio[0].duration);

//     $seekBar.val((currentTime / duration) * 100);

//     $currentTimeEl.text(formatTime(currentTime));
//     $durationEl.text(formatTime(duration));
//   });

//   // Seek functionality
//   $seekBar.on('input', function () {
//     var duration = Math.floor($audio[0].duration);
//     var seekTo = ($seekBar.val() / 100) * duration;
//     $audio[0].currentTime = seekTo;
//   });

//   // Volume control
//   $volumeBar.on('input', function () {
//     var volume = $volumeBar.val() / 100;
//     $audio[0].volume = volume;
//   });

//   // Format time in mm:ss
//   function formatTime(time) {
//     var minutes = Math.floor(time / 60);
//     var seconds = Math.floor(time % 60);
//     return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
//   }

//   // Set initial duration and volume
//   $audio.on('loadedmetadata', function () {
//     $durationEl.text(formatTime($audio[0].duration));
//   });

//   // Initialize volume control
//   $volumeBar.val($audio[0].volume * 100);
// });

jQuery(function ($) {
  const $audio = $('#audio');
  const $playPauseBtn = $('#play-pause');
  const $seekBar = $('#seek-bar');
  const $volumeBar = $('#volume-bar');
  const $muteBtn = $('#mute-button');
  const $currentTimeEl = $('#current-time');
  const $durationEl = $('#duration');

  // Play/Pause button functionality
  $playPauseBtn.on('click', function () {
    if ($audio[0].paused) {
      $audio[0].play().catch(function (error) {
        console.error('Error playing audio:', error);
      });
      $playPauseBtn.removeClass('play').addClass('pause');
    } else {
      $audio[0].pause();
      $playPauseBtn.removeClass('pause').addClass('play');
    }
  });

  // Update seek bar and time
  $audio.on('timeupdate', function () {
    const currentTime = Math.floor($audio[0].currentTime);
    const duration = Math.floor($audio[0].duration);

    const seekValue = (currentTime / duration) * 100;
    $seekBar.val(seekValue);
    updateSeekBarColor(seekValue);

    $currentTimeEl.text(formatTime(currentTime));
    $durationEl.text(formatTime(duration));
  });

  // Seek functionality
  $seekBar.on('input', function () {
    const duration = Math.floor($audio[0].duration);
    const seekTo = ($seekBar.val() / 100) * duration;
    $audio[0].currentTime = seekTo;
    updateSeekBarColor($seekBar.val());
  });

  // Volume control
  $volumeBar.on('input', function () {
    const volume = $volumeBar.val() / 100;
    $audio[0].volume = volume;
    updateVolumeBarColor($volumeBar.val());
  });

  // Mute/Unmute functionality
  $muteBtn.on('click', function () {
    if ($audio[0].muted) {
      $audio[0].muted = false;
      $muteBtn.removeClass('mute').addClass('unmute');
      $volumeBar.val($audio[0].volume * 100);
    } else {
      $audio[0].muted = true;
      $muteBtn.removeClass('unmute').addClass('mute');
      $volumeBar.val(0);
    }
  });

  // Format time in mm:ss
  function formatTime(time) {
    var minutes = Math.floor(time / 60);
    var seconds = Math.floor(time % 60);
    return minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
  }

  // Set initial duration and volume
  $audio.on('loadedmetadata', function () {
    $durationEl.text(formatTime($audio[0].duration));
  });

  // Initialize volume control
  $volumeBar.val($audio[0].volume * 100);
  updateVolumeBarColor($volumeBar.val());

  // Function to update the color of the seek bar
  function updateSeekBarColor(value) {
    $seekBar.css('background', `linear-gradient(to right, #7C7413 ${value}%, #ddd ${value}%)`);
  }

  // Function to update the color of the volume bar
  function updateVolumeBarColor(value) {
    $volumeBar.css('background', `linear-gradient(to right, #7C7413 ${value}%, #ddd ${value}%)`);
  }

  // Set initial seek bar and volume bar colors
  // updateSeekBarColor($seekBar.val());
  // updateVolumeBarColor($volumeBar.val());
});
