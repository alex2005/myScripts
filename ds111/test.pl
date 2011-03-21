#!/usr/bin/perl -W

use strict;

require File::Spec::Unix; # Done automatically by File::Spec

my $escapedir;
my $depth = 0;
my $debug = 1;

# von welchen verzeichnissen
#my @names = qw(/volume1/music/specials/ /volume1/music/mp31/ /volume1/music/mp32/ /volume1/music/mp33/);
my @names = qw(/data/bck/testmp3/mp31/ /data/bck/testmp3/mp32/);
# wohin
#my $zieldir = "/volume1/s100";
my $zieldir = "/data/bck/s100/";
# nicht diese verzeichnisse teilnamen gehen auch!
my @ddir = qw(@eaDir hoerspiele karaoke benjamin_bluemchen);

# damit kann man die relative ../ pfade erhoehen/erniedrigen 0 = ../../../
my $reldir = 0;
# link zaehler
my $counter = 0;

# fuer das @names array
my $n = 0;

sub mknicename
{
   my ($str) = shift;
   $str =~ tr/_/ /;
   $str = lc($str);
   $str =~ s/\b(\w)/\u$1/g;
   return $str;
}

sub escape {
  my($str) = splice(@_);
  $str =~ s/\//\\\//g;
  $str =~ s/\@/\\\@/g;
  return $str;
}

sub inarray {
   my($str) = @_;
   my ($line) = "";
   foreach $line (@ddir){
   if ($str =~ m/$line/){
      return 1;
   } # end if
   } # end foreach
return 0;
}

sub recurse {
  my($path,$pdir) = @_;

  ## append a trailing / if it's not there
  $path .= '/' if($path !~ /\/$/);
  $depth += 1;
  
  ## print the directory being searched
  #print "### ", $path," - ", $pdir, "\n";

  ## loop through the files contained in the directory
  for my $eachFile (glob($path.'*')) {

    ## if the file is a directory
#    if( -d $eachFile and not ( $eachFile =~ m/\@eaDir/ ) ) {
    if( -d $eachFile and not ( inarray($eachFile) ) ) {
      ## pass the directory to the routine &( recursion )

      my @newdir = split (/$escapedir/, $eachFile);
      my $tmpdirname = mknicename($newdir[1]);
      
      if ( $debug) { 
      	print "### mkdir \"".$zieldir.$tmpdirname."\"\n";
	} else {
      	my $mk_dir = qx(mkdir -p "$zieldir$tmpdirname");
	}
      recurse($eachFile, $newdir[1]);
    } else {
	    if( not ( inarray($eachFile) ) and ( $eachFile =~ m/\.(mp3|MP3|ogg|jpg)/ ) ) {

	      ## print the file ... tabbed for readability
      		my @newdir = split (/$escapedir/, $eachFile);
      		my @filename = split (/$pdir\//, $newdir[1]);
		
	      my $lnsource = $pdir."\/".$filename[1];
	      my $lndest = $zieldir.mknicename($newdir[1]);
	      if ( $debug) { 
		my $rel_path = File::Spec::Unix->abs2rel( $names[$n], $pdir ) ;
		#print "\tRelPath: ".$rel_path."\n";
		print "\tln -s \"$rel_path/$lnsource\" \"$lndest\"\n";
		} else {
      		my $mk_ln = qx(ln -s "$rel_path/$lnsource" "$lndest"); 
		}
	      $counter++;
	      }
    }
  }
  $depth -= 1;
}

while ($names[$n]) {
$escapedir = escape($names[$n]);
recurse($names[$n], "");
$n++;
}

print "Links gemacht: ", $counter, "\n";
