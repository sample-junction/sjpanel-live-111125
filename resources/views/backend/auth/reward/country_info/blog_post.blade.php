   <p>
      <strong style="color: windowtext">🌟 Celebrating Our Star Panelists of {{$month}}, {{$country}}</strong><strong style="color: windowtext">! 🌟&nbsp;</strong>
   </p>
   <p>
      <span style="color: windowtext">At </span><a
         href="https://www.sjpanel.com/"
         target="_blank"
         style="color: windowtext">SJ Panel</a><span style="color: windowtext">, we truly value the time, effort, and dedication of our panelists.
         Every month, we recognize and reward our most active and committed
         members who help us grow stronger by sharing their valuable
         opinions.&nbsp;</span>
   </p>
   <div contenteditable="false" data-layout="default" class="embedded_image">
      <img alt="" src="{{ $banner_image }}" />
   </div>
   <p>
      <span style="color: windowtext">We’re excited to announce the </span><strong style="color: windowtext">SJ Panel {{$month}}</strong><strong style="color: windowtext"> Monthly Award Winners</strong><span style="color: windowtext"> from {{$country}}</span><span style="color: windowtext">! 🏆&nbsp;</span>
   </p>


   @if($winners)
   @foreach ($winners as $item)
   @php
   $winner = implode(' ', array_filter([
   decrypt($item->first_name),
   decrypt($item->middle_name),
   decrypt($item->last_name),
   ]));
   $address = $item->city_state;
   @endphp

   @if ($item->award_type == 3)
   <h2>
      <span style="color: windowtext">&nbsp;🏅 </span><strong style="color: windowtext">Most Active Panelist – {{$winner}}</strong><span style="color: windowtext">&nbsp;</span>
   </h2>
   <p>
      <strong style="color: windowtext">📍 From:</strong><span style="color: windowtext">{{$address}}</span><span style="color: windowtext">&nbsp;</span>
   </p>
   <p>
      <span style="color: windowtext">This award goes to the panelist who showed the most dedication by
         consistently participating in surveys throughout {{$month}}</span><span style="color: windowtext">. Congratulations, {{$winner}}</span><span style="color: windowtext">, for being our </span><strong style="color: windowtext">Most Active Panelist</strong><span style="color: windowtext">! Your commitment keeps the SJ Panel community thriving.&nbsp;</span>
   </p>

   @elseif($item->award_type == 2)
   <h2>
      <strong style="color: windowtext">🌟 Survey Superstar – {{$winner}}</strong><span style="color: windowtext">&nbsp;</span>
   </h2>
   <p>
      <strong style="color: windowtext">📍 From:</strong><span style="color: windowtext">{{$address}}</span><span style="color: windowtext">&nbsp;</span>
   </p>
   <p>
      <span style="color: windowtext">The </span><strong style="color: windowtext">Survey Superstar</strong><span style="color: windowtext">
         award is given to the panelist with outstanding survey participation
         and completion rate in{{$month}}</span><span style="color: windowtext">. Well done, {{$winner}}</span><span style="color: windowtext">, for your enthusiasm and accuracy while taking surveys – you truly
         deserve this recognition!&nbsp;</span>
   </p>

   @elseif($item->award_type == 1)
   <h2>
      <span style="color: windowtext">🎯 </span><strong style="color: windowtext">Profile Prodigy – {{$winner}}</strong><span style="color: windowtext">&nbsp;</span>
   </h2>
   <p>
      <strong style="color: windowtext">📍 From:</strong><span style="color: windowtext">{{$address}}</span><span style="color: windowtext">&nbsp;</span>
   </p>
   <p>
      <span style="color: windowtext">The </span><strong style="color: windowtext">Profile Prodigy</strong><span style="color: windowtext">
         award goes to the panelist who kept their SJ Panel profile updated and
         provided high-quality responses in surveys during {{$month}}</span><span style="color: windowtext">. Congratulations, {{$winner}}</span><span style="color: windowtext">, for maintaining excellence and helping us deliver the best
         insights!&nbsp;</span>
   </p>

   @endif
   @endforeach
   @endif

   <p><h3 style="color: windowtext">&nbsp;🎉 Final Words&nbsp;</h3></p>
   <p>
      <span style="color: windowtext">A big </span><strong style="color: windowtext">thank you</strong><span style="color: windowtext"> to all our panelists in {{$country}}</span><span style="color: windowtext"> who took part in surveys during {{$month}}</span><span style="color: windowtext">. Every opinion matters, and your contributions help shape meaningful
         insights for businesses worldwide.&nbsp;</span>
   </p>
   <p>
      <span style="color: windowtext">✨ Stay tuned for next month’s award ceremony – it might be </span><strong style="color: windowtext">your name</strong><span style="color: windowtext"> on this list!&nbsp;</span>
   </p>
   <p>
      <span style="color: windowtext">👉 Haven’t downloaded the </span><strong style="color: windowtext">SJ Panel Mobile App</strong><span style="color: windowtext"> yet?&nbsp;</span>
   </p>
   <p>
      Download now on
      <a
         href="https://play.google.com/store/apps/details?id=com.sjpanel&amp;pcampaignid=web_share"
         target="_blank"
         style="color: windowtext"><strong>Google Play</strong></a><span style="color: windowtext"> or the </span><a
         href="https://apps.apple.com/us/app/sj-panel/id6743372465"
         target="_blank"
         style="color: windowtext"><strong>App Store</strong></a><span style="color: windowtext">
         and start participating today. 🚀&nbsp;</span>
   </p>