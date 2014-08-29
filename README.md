Default Entry Types is a simple plugin for Craft CMS that forces entry types on certain levels of their structure.

To install, clone the repo in your craft plugins directory.

__Use:__ 
It's pretty simple rght now - you can assign each entry type an integer that corresponds with the level of a structure. If you want an entrytype to only exist on the second level of a structure, give it a '2' in its input field.

If you assign 0 or leave an input blank for an entrytype, it won't affect that level's entrytypes.

The plugin currently does not affect database records of entries; it only auto-selects entrytypes when creating or editing entries in a structure section and disables the dropdown.
