<ul id="rightClickMenu" class="rightClickMenu">
	{if (!$guest)}
	<li class="new">				<span class="entypo entypo-folder"></span>			<a href="#newFolder">New Subfolder</a></li>
	<li class="upload">				<span class="entypo entypo-upload"></span>			<a href="#upload">Upload</a></li>
	{/if}
	<li class="download">			<span class="entypo entypo-download"></span>		<a href="#download">Download</a></li>	
	{if (!$guest)}
	<li class="link">				<span class="entypo entypo-link"></span>			<a href="#getLink">Get Link</a></li>
	<li class="restore separator">	<span class="entypo entypo-level-up"></span>		<a href="#restore">Restore</a></li>
	<li class="delete separator">	<span class="entypo entypo-trash"></span>			<a href="#delete">Delete</a></li>
	<!-- <li class="deletePermanent">	<span class="entypo entypo-trash"></span> 			<a href="#deletePermanent">Annihilate!</a></li> -->
	<li class="deletePermanent">	<span class="entypo entypo-trash"></span> 			<a href="#deletePermanent">Vanquish!</a></li>
	<li class="edit">				<span class="entypo entypo-pencil"></span>			<a href="#rename">Rename</a></li>
	<li class="zip separator">		<span class="entypo entypo-install"></span>			<a href="#extract">Extract</a></li>
	<li class="details separator">	<span class="entypo entypo-list"></span>	<a id="btnMenuShowInfo" href="#loadDetails">Show Properties</a></li>
	<li class="emptyTrash">			<span class="entypo entypo-flash"></span>			<a href="#emptyTrash">Empty Trash</a></li>
	<li class="cancel">				<span class="entypo entypo-cancel-circled"></span>	<a href="#cancel">Cancel</a></li>
	{/if}
</ul>
