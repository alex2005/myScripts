#!/usr/bin/perl
# cd /volume1/s100/
# ./mklinks.pl 

sub ucwords
 {
   $str = shift;
   $str = lc($str);
   $str =~ s/\b(\w)/\u$1/g;
   return $str;
 }

sub UPPER
{
       $str = shift;
    $str =~ tr/_/ /;
    $str = ucwords($str);
       return $str;
}

# DEFINE AN ARRAY
@names = qw(/home/dorn/mp3/jd/);
$zieldir = "/home/dorn/temp/musik/";

$debug = 1;
# COUNTER - COUNTS EACH ROW
$count = 1;

# diese Verzeichnisse auslassen
my @ddir=qw(. .. karaoke hoerspiele) ;

# Variable wenn nur Files gelinkt werden. Nur einmal und nicht jedesmal
# wenn das Direktory geprueft wird.
$file = 0;
# COUNTS EACH ELEMENT OF THE ARRAY
$n = 0;

# USE THE SCALAR FORM OF ARRAY
while ($names[$n]) {
    opendir(DIRHANDLE,"$names[$n]")||die "ERROR: can not read current directory\n";
    foreach (readdir(DIRHANDLE)){
      #print"$_ @ddir \n";
      if ( grep /$_$/, @ddir ) {
      $artist = $_;
      $ArtistName = UPPER($_);
      #$ArtistName =~ tr/_/ /;
      #$ArtistName = ucwords($ArtistName);
      print"$names[$n]$_\n";

	if ( -d "$names[$n]$_") {
        	if ( not -d "$zieldir$ArtistName" ) {
        	    if ( $debug) { print "mkdir -p \"$zieldir$ArtistName\"\n"; }
        	    if ( not $debug) { my $mk_dir = qx(mkdir -p "$zieldir$ArtistName"); }
        	}
        	opendir(DIRHANDLE2,"$names[$n]$_")||die "ERROR: can not read current directory\n";
        	foreach (readdir(DIRHANDLE2)){
        	 if ( not ( $_ eq "." or $_ eq ".." ) ) {
        	    if ( -d "$names[$n]$artist/$_") {
        		$AlbumName = UPPER($_);
        		#print "Album: $AlbumName\n";
        		if ( $debug) { print "cd \"$zieldir$ArtistName\"\nln -s \"../$names[$n]$artist/$_\" \"$AlbumName\" \n"; }
        		if ( not $debug) { my $ln_befehl = qx(cd "$zieldir$ArtistName" && ln -s "../$names[$n]$artist/$_" "$AlbumName"); }
        		$count++;
        	    } elsif ( $file != 1 ) {
        		if ( $debug) { print "###FILE###\ncd \"$zieldir$ArtistName\"\nln -s ../$names[$n]$artist/* \".\"\n"; }
        		if ( not $debug) { my $ln_befehl = qx(cd "$zieldir$ArtistName" && ln -s ../$names[$n]$artist/* .); }
			$file = 1;
        		#print "File $names[$n]$artist/$_";
        	    }
        	}
        	}
        	closedir DIRHANDLE2;
		$file = 0;
	}
      }
    }
    closedir DIRHANDLE;
    #print "Dirs: $count in $names[$n] ArrayNummer: $n\n";
    $n++;
}
print "Insgesamt $count symblische Links\n";
