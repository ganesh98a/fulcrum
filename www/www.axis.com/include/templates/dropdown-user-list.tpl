
{if isset($dropdownUserListOnChange) && !empty($dropdownUserListOnChange)}
{html_options id="ddl_user_id" class="gc_user_search" name=ddl_user_id options=$arrUserOptions selected=$selectedUser }
{else}
{html_options id="ddl_user_id"  class="gc_user_search" name=ddl_user_id options=$arrUserOptions selected=$selectedUser}
{/if}
