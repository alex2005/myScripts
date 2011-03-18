#!/usr/bin/perl -W

use strict;

my $escapedir;
my $depth = 0;

# von welchen verzeichnissen
my @names = qw(/home/dorn/mp3/jd/);
# wohin
my $zieldir = "/home/dorn/temp/musik/";
# nicht diese verzeichnisse
my @ddir = qw(@eaDir hoerspiele karaoke wii bresslufd);

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

sub dots {
    my($dot) = @_;
    my ($str) = "" ;
    while ($dot > $reldir) {
	$str = "../" . $str;
	$dot -= 1;
    }
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
  #print $path," - ", $pdir, "\n";

  ## loop through the files contained in the directory
  for my $eachFile (glob($path.'*')) {

    ## if the file is a directory
#    if( -d $eachFile and not ( $eachFile =~ m/\@eaDir/ ) ) {
    if( -d $eachFile and not ( inarray($eachFile) ) ) {
      ## pass the directory to the routine &( recursion )

      my @newdir = split (/$escapedir/, $eachFile);
      print "### mkdir \"".mknicename($newdir[1])."\"\n";
      recurse($eachFile, $newdir[1]);
    } else {
	    if( not ( inarray($eachFile) ) and ( $eachFile =~ m/\.(mp3|MP3|ogg|jpg)/ ) ) {

	      ## print the file ... tabbed for readability
      		my @newdir = split (/$escapedir/, $eachFile);
      		my @filename = split (/$pdir\//, $newdir[1]);
		
	      #zu lang print "\tln -s \"",dots($depth),mknicename($pdir),"\/", $filename[1] ,"\" \"" ,$zieldir,  $newdir[1],"\"", "\n";
	      print "\tln to \"",dots($depth),mknicename($pdir),"\/", $filename[1],"\"\n";
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
